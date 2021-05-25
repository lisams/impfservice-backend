<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use App\Models\Vaccination;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaccinationController extends Controller
{
    /** READ all vaccination */
    public function index() {
        return Vaccination::with(['location', 'users'])->orderBy('date', 'ASC')->get();
    }

    /** READ all upcoming vaccinations */
    public function getUpcomingVaccinations() {
        return Vaccination::with(['location', 'users'])->orderBy('date', 'ASC')->where('date', '>', DB::raw('NOW()'))->get();
    }

    /** READ all upcoming vaccination with open slots */
    public function getUpcomingVaccinationsOpenSlots() {
        $vaccs = Vaccination::with(['location', 'users'])
            ->orderBy('date', 'ASC')
            ->where('date', '>', DB::raw('NOW()'))
            ->get();
        $vaccs1 = [];

        foreach ($vaccs as $vacc) {
            if($vacc->users->count() < $vacc->max_participants) {
                $vaccs1[] = $vacc;
            }
        }
        return $vaccs1;
    }

    /** READ single vaccination by id */
    public function findVaccinationById(string $id): Vaccination {
        $vacc = Vaccination::where('id', $id)
            ->with(['location', 'users'])
            ->first();
        return $vacc;
    }

    /** DELETE single vaccination by id */
    public function removeVaccinationById(string $id): JsonResponse {
        $vacc = Vaccination::where('id', $id)
            ->with(['location'])
            ->first();
        if ($vacc != null) {
            $users = User::where('vaccination_id', $id)->get();
            if ($users->count() > 1) {
                foreach ($users as $user) {
                    $user->vaccination_id = NULL;
                    $user->save();
                }
            } else if ($users->count() == 1) {
                $users->first()->vaccination_id = NULL;
                $users->first()->save();
            }
            $vacc->delete();
        } else {
            return response()->json("vaccination (" . $id . ") does not exist", 200);
        }
        return response()->json('vaccination (' . $id . ') successfully deleted');
    }

    /** CREATE new vaccination */
    public function createVaccination(Request $request): JsonResponse {
        $request = $this->parseRequest($request);

        DB::beginTransaction();
        try {
            // save address
            $address = Address::firstOrCreate($request['location']['address']);

            // save location
            $location = Location::firstOrCreate(
                [
                    'title' => $request['location']['title'],
                    'description' => $request['location']['description'] ? $request['location']['description'] : null,
                    'address_id' => $address->id
                ]
            );

            // save vaccination
            // create STATT firstOrCreate, weil es soll mehrmals eine Impfung angelegt werden können
            $vaccination = Vaccination::create([
                'date' => $request['date'],
                'start' => $request['start'],
                'end' => $request['end'],
                'max_participants' => $request['max_participants'],
                'location_id' => $location->id
            ]);
            $vaccination->save();

            // DB commit
            DB::commit();
            $vacc1 = Vaccination::with(['location', 'users'])
                ->where('id', $vaccination->id)->first();
            return response()->json($vacc1, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving vaccination failed: " . $e->getMessage(), 420);
        }
    }

    /** UPDATE single vaccination by id */
    public function updateVaccinationById(Request $request, string $id): JsonResponse {
        DB::beginTransaction();
        try {

            // update vaccination values
            $vacc = Vaccination::with(['location', 'users'])
                ->where('id', $id)->first();
            $vacc->update([
                    'date' => $request['date'],
                    'start' => $request['start'],
                    'end' => $request['end'],
                    'max_participants' => $request['max_participants'],
                    'location_id' => $vacc->location_id
                ]
            );
            $vacc->save();

            // update location infos
            $location = Location::where('id', $vacc->location_id)->first();
            $location->update([
                'title' => $request['location']['title'],
                'description' => $request['location']['description'] ? $request['location']['description'] : null,
                'address_id' => $location->address_id
            ]);
            $location->save();

            // update address
            $address = Address::where('id', $location->address_id)->first();
            $address->update([
                    'street_address' => $request['location']['address']['street_address'],
                    'zip_code' => $request['location']['address']['zip_code'],
                    'city' => $request['location']['address']['city']
                ]
            );
             $address->save();

            DB::commit();
            $vacc1 = Vaccination::with(['location', 'users'])
                ->where('id', $id)->first();
            return response()->json($vacc1, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("updating book failed: " . $e->getMessage(), 420);
        }
    }

    /** modify / convert values if needed */
    private function parseRequest(Request $request): Request
    {
        // get date and convert it - its in ISO 8601, e.g. "2018-01-01T23:00:00.000Z"
        $date = new \DateTime($request->date);
        $request['date'] = $date;
        return $request;
    }
}

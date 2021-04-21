<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use App\Models\Vaccination;
use App\Models\Location;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaccinationController extends Controller
{
    public function index()
    {
        return Vaccination::with(['location', 'users'])->orderBy('date', 'ASC')->get();
    }

    public function findByID(string $id): Vaccination
    {
        $vacc = Vaccination::where('id', $id)
            ->with(['location', 'users'])
            ->first();
        return $vacc;
    }

    public function getOpenSlots(string $id)
    {
        $maxParticipants = Vaccination::where('id', $id)
            ->with(['users'])->first()->max_participants;
        $participants = DB::table('vaccinations')
            ->join('users', 'users.vaccination_id', '=', 'vaccinations.id')
            ->where('vaccinations.id', $id)
            ->count();
        return response($maxParticipants - $participants, 200);

        // SELECT COUNT(*)
        // FROM vaccinations
        // INNER JOIN users ON vaccinations.id = users.vaccination_id
        // WHERE (vaccinations.id=xy)
    }

    public function remove(string $id): JsonResponse
    {
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

    public function create(Request $request): JsonResponse
    {
        $request = $this->parseRequest($request);

        // var_dump($request['location']['address']['city']);
        //die();

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
            // TODO create OR firstOrCreate --> soll mehrmals eine Impfung angelegt werden können?
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
            return response()->json($vaccination, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving vaccination failed: " . $e->getMessage(), 420);
        }

    }

    public function update(Request $request, string $id): JsonResponse {
        DB::beginTransaction();
        try {

            // TODO UPDATE BOOK

            DB::commit();
            $vacc1 = Vaccination::with(['location', 'users'])
                ->where('id', $id)->first();
            return response()->json($vacc1, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("updating book failed: " . $e->getMessage(), 420);
        }
    }

    /**
     * modify / convert values if needed
     */
    private
    function parseRequest(Request $request): Request
    {
        // get date and convert it - its in ISO 8601, e.g. "2018-01-01T23:00:00.000Z"
        $date = new \DateTime($request->date);
        $request['date'] = $date;
        return $request;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Location;
use App\Models\Vaccination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /** READ all locations */
    public function index()
    {
        return Location::with(['address'])->get();
    }

    /** READ single location by id */
    public function findLocationById(string $id)
    {
        $location = Location::where('id', $id)
            ->with(['address'])
            ->first();
        return $location;
    }

    /** CREATE new location */
    public function createLocation(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $address = Address::firstOrCreate($request['address']);
            $location = Location::firstOrCreate(
                [
                    'title' => $request['title'],
                    'description' => $request['description'] ? $request['description'] : null,
                    'address_id' => $address->id
                ]
            );

            DB::commit();
            $location1 = Location::with(['address'])
                ->where('id', $location->id)->first();
            return response()->json($location1, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving location failed: " . $e->getMessage(), 420);
        }
    }

    /** DELETE location by id */
    public function removeLocationById(string $id): JsonResponse
    {
        $location = Location::where('id', $id)
            ->with(['address'])
            ->first();
        if ($location != null) {
            $vaccs = Vaccination::where('location_id', '=', $id)->get();
            if ($vaccs->count() === 0) {
                $location->delete();
            } else {
                return response()->json('location (' . $id . ') cannot be deleted, because there are vaccinations taking place there', 403);
            }
        } else {
            return response()->json("location (" . $id . ") does not exist", 200);
        }
        return response()->json('location (' . $id . ') successfully deleted');
    }

    /** UPDATE location by id */
    public function updateLocationById(Request $request, string $id)
    {
        DB::beginTransaction();
        try {

            // update location
            $location = Location::where('id', $id)->first();
            $location->update([
                'title' => $request['title'],
                'description' => $request['description'] ? $request['description'] : null,
                'address_id' => $location->address_id
            ]);
            $location->save();

            // update address
            $address = Address::where('id', $location->address_id)->first();
            $address->update([
                    'street_address' => $request['address']['street_address'],
                    'zip_code' => $request['address']['zip_code'],
                    'city' => $request['address']['city']
                ]
            );
            $address->save();

            DB::commit();
            $location1 = Location::with(['address'])
                ->where('id', $id)->first();
            return response()->json($location1, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("updating book failed: " . $e->getMessage(), 420);
        }
    }
}

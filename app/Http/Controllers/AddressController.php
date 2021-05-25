<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{

    /** READ all addresses */
    public function index()
    {
        return Location::with(['address'])->get();
    }

    /** READ single address by id */
    public function findAddressById(string $id)
    {
        $address = Address::where('id', $id)->first();
        return $address;
    }

    /** CREATE new address */
    public function createAddress(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $address = Address::firstOrCreate([
                'street_address' => $request['street_address'],
                'zip_code' => $request['zip_code'],
                'city' => $request['city']
            ]);
            DB::commit();
            $address1 = Address::where('id', $address->id)->first();
            return response()->json($address1, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving address failed: " . $e->getMessage(), 420);
        }
    }

    /** UPDATE address by id */
    public function updateAddressById(Request $request, string $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $address = Address::where('id', $id)->first();
            $address->update([
                    'street_address' => $request['street_address'],
                    'zip_code' => $request['zip_code'],
                    'city' => $request['city']
                ]
            );
            $address->save();

            DB::commit();
            $address1 = Address::where('id', $id)->first();
            return response()->json($address1, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("updating address failed: " . $e->getMessage(), 420);
        }
    }

    /** DELETE address by id */
    public function removeAddressById(string $id): JsonResponse
    {
        $address = Address::where('id', $id)
            ->first();
        if ($address != null) {
            $locations = Location::where('address_id', '=', $id)->get();
            $users = User::where('address_id', '=', $id)->get();
            if ($locations->count() === 0 && $users->count() === 0) {
                $address->delete();
            } else {
                return response()->json('address (' . $id . ') cannot be deleted, because there are locations/users which take place at this address', 403);
            }
        } else {
            return response()->json("address (" . $id . ") does not exist", 200);
        }
        return response()->json('address (' . $id . ') successfully deleted');
    }
}

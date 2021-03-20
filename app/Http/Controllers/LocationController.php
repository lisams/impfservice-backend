<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function index() {
        return Location::with(['address'])->get();
    }

    public function findByZIP(string $zip) {
        $locations = DB::table('locations')
            ->join('addresses', 'locations.address_id', '=', 'addresses.id')
            ->where('addresses.zip_code', '=', $zip)->get();
        return $locations->count() > 0 ? $locations : response()->json("no locations in this city available", 200);

        // SELECT * FROM locations
        // INNER JOIN addresses ON locations.address_id = addresses.id
        // WHERE addresses.zip_code = yxc
    }
}

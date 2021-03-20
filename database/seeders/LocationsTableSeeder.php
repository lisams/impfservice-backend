<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location = new Location();
        $location->title = 'Messezentrum Wels';
        $location->description = 'Messehalle 11/12/14';
        $location->address_id = 5;
        $location->save();

        $location2 = new Location();
        $location2->title = 'Designcenter Linz';
        $location2->address_id = 6;
        $location2->save();

        $location3 = new Location();
        $location3->title = 'Raiffeisenbank Micheldorf';
        $location3->description = 'Mitten im Ortszentrum, Haupteingang links';
        $location3->address_id = 7;
        $location3->save();
    }
}

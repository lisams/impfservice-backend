<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Vaccination;
use Illuminate\Database\Seeder;

class VaccinationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vacc = new Vaccination();
        $vacc->date = '2021-04-05';
        $vacc->max_participants = 80;
        $vacc->location_id = 1;
        $vacc->save();

        $vacc2 = new Vaccination();
        $vacc2->date = '2021-04-06';
        $vacc2->max_participants = 50;
        $vacc2->location_id = 1;
        $vacc2->save();

        $vacc3 = new Vaccination();
        $vacc3->date = '2021-05-10';
        $vacc3->max_participants = 120;
        $vacc3->location_id = 2;
        $vacc3->save();

        $vacc4 = new Vaccination();
        $vacc4->date = '2021-05-12';
        $vacc4->max_participants = 120;
        $vacc4->location_id = 2;
        $vacc4->save();

        $vacc5 = new Vaccination();
        $vacc5->date = '2021-05-14';
        $vacc5->max_participants = 100;
        $vacc5->location_id = 2;
        $vacc5->save();

        $vacc6 = new Vaccination();
        $vacc6->date = '2021-04-02';
        $vacc6->max_participants = 42;
        $vacc6->location_id = 3;
        $vacc6->save();

        $vacc7 = new Vaccination();
        $vacc7->date = '2021-04-03';
        $vacc7->max_participants = 48;
        $vacc7->location_id = 3;
        $vacc7->save();
    }
}

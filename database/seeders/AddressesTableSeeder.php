<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address = new Address();
        $address->street_address = 'Ziehbergstraße 34';
        $address->zip_code = '4562';
        $address->city = 'Steinbach/Ziehberg';
        $address->save();

        $address1 = new Address();
        $address1->street_address = 'Goethestraße 32b/8';
        $address1->zip_code = '4020';
        $address1->city = 'Linz';
        $address1->save();

        $address2 = new Address();
        $address2->street_address = 'Untergaumberg 302';
        $address2->zip_code = '4030';
        $address2->city = 'Linz';
        $address2->save();

        $address3 = new Address();
        $address3->street_address = 'Friedrich-Schiller-Weg 20';
        $address3->zip_code = '4082';
        $address3->city = 'Wels';
        $address3->save();

        $address4 = new Address();
        $address4->street_address = 'Messeplatz 1';
        $address4->zip_code = '4600';
        $address4->city = 'Wels';
        $address4->save();

        $address5 = new Address();
        $address5->street_address = 'Europaplatz 1';
        $address5->zip_code = '4020';
        $address5->city = 'Linz';
        $address5->save();

        $address5 = new Address();
        $address5->street_address = 'Hauptplatz 5';
        $address5->zip_code = '4563';
        $address5->city = 'Micheldorf';
        $address5->save();
    }
}

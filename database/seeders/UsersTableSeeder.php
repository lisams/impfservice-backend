<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->sv_nr = '4109';
        $user->date_of_birth = '1980-06-14';
        $user->firstname = 'Mirjam';
        $user->lastname = 'Huber';
        $user->gender = 'female';
        $user->email = 'mirjam@huber.com';
        $user->phone = '+43 650 300 34 53';
        $user->password = bcrypt('test1234!');
        $user->address_id = 3;
        $user->save();

        $user1 = new User();
        $user1->sv_nr = '2340';
        $user1->date_of_birth = '1974-02-28';
        $user1->firstname = 'Thomas';
        $user1->lastname = 'Mayr';
        $user1->gender = 'male';
        $user1->email = 't.mayr@test.com';
        $user1->phone = '+43 660 923 15 63';
        $user1->password = bcrypt('test1234!');
        $user1->address_id = 4;
        $user1->save();

        $user = new User();
        $user->sv_nr = '9830';
        $user->date_of_birth = '1978-06-14';
        $user->firstname = 'Bernhard';
        $user->lastname = 'Huber';
        $user->gender = 'female';
        $user->email = 'bernhard@huber.com';
        $user->phone = '+43 667 143 98 74';
        $user->password = bcrypt('test1234!');
        $user->address_id = 3;
        $user->vaccination_id = 4;
        $user->save();

        $user = new User();
        $user->sv_nr = '8270';
        $user->date_of_birth = '1990-06-24';
        $user->firstname = 'Sarah';
        $user->lastname = 'Müllheim';
        $user->gender = 'female';
        $user->email = 'sarah.m@gmail.com';
        $user->phone = '+43 650 144 26 02';
        $user->password = bcrypt('test1234!');
        $user->address_id = 3;
        $user->vaccination_id = 6;
        $user->save();

        $user = new User();
        $user->sv_nr = '1084';
        $user->date_of_birth = '1949-06-24';
        $user->firstname = 'Henriette';
        $user->lastname = 'Obermayr';
        $user->gender = 'female';
        $user->email = 'hobermayr1949@gmail.com';
        $user->phone = '+43 699 234 54 09';
        $user->password = bcrypt('test1234!');
        $user->address_id = 2;
        $user->vaccination_id = 1;
        $user->save();

        $user = new User();
        $user->sv_nr = '9735';
        $user->date_of_birth = '1948-11-04';
        $user->firstname = 'Rudolf';
        $user->lastname = 'Obermayr';
        $user->gender = 'male';
        $user->email = 'robermayr1948@gmail.com';
        $user->phone = '+43 699 234 54 08';
        $user->password = bcrypt('test1234!');
        $user->address_id = 2;
        $user->vaccination_id = 1;
        $user->save();

        $user = new User();
        $user->sv_nr = '3402';
        $user->date_of_birth = '1960-11-04';
        $user->firstname = 'Sabine';
        $user->lastname = 'Traxler';
        $user->gender = 'female';
        $user->email = 'sabine@traxler.at';
        $user->phone = '+43 664 034 12 02';
        $user->password = bcrypt('test1234!');
        $user->address_id = 4;
        $user->vaccination_id = 1;
        $user->save();

        $user = new User();
        $user->sv_nr = '9034';
        $user->date_of_birth = '2002-11-04';
        $user->firstname = 'Lukas';
        $user->lastname = 'Traxler';
        $user->gender = 'male';
        $user->email = 'lukas@traxler.at';
        $user->phone = '+43 664 235 12 94';
        $user->password = bcrypt('test1234!');
        $user->address_id = 4;
        $user->vaccination_id = 1;
        $user->save();

        $user = new User();
        $user->sv_nr = '2489';
        $user->date_of_birth = '1998-11-04';
        $user->firstname = 'Larissa';
        $user->lastname = 'Liesbacher';
        $user->gender = 'female';
        $user->email = 'lliesbacher@gmx.at';
        $user->phone = '+43 660 023 63 23';
        $user->password = bcrypt('test1234!');
        $user->address_id = 4;
        $user->vaccination_id = 1;
        $user->save();

        $user = new User();
        $user->sv_nr = '4053';
        $user->date_of_birth = '1998-11-04';
        $user->firstname = 'Harald';
        $user->lastname = 'König';
        $user->gender = 'male';
        $user->email = 'harald.koenig@gmx.at';
        $user->phone = '+43 664 325 54 13';
        $user->password = bcrypt('test1234!');
        $user->address_id = 4;
        $user->vaccination_id = 1;
        $user->save();

        $user = new User();
        $user->sv_nr = '2492';
        $user->date_of_birth = '1978-11-04';
        $user->firstname = 'Herta';
        $user->lastname = 'Plemmbacher';
        $user->gender = 'female';
        $user->email = 'hplemmbacher@gmx.at';
        $user->phone = '+43 660 235 45 02';
        $user->password = bcrypt('test1234!');
        $user->address_id = 4;
        $user->vaccination_id = 1;
        $user->save();

        $user = new User();
        $user->sv_nr = '2392';
        $user->date_of_birth = '1974-11-04';
        $user->firstname = 'Martin';
        $user->lastname = 'Plemmbacher';
        $user->gender = 'male';
        $user->email = 'plemmbacher.m@gmail.at';
        $user->phone = '+43 650 234 08 32';
        $user->password = bcrypt('test1234!');
        $user->address_id = 4;
        $user->vaccination_id = 1;
        $user->save();

        $user = new User();
        $user->sv_nr = '5492';
        $user->date_of_birth = '1974-11-04';
        $user->firstname = 'Dieter';
        $user->lastname = 'Heilemann';
        $user->gender = 'male';
        $user->email = 'heilemann.dieter@gmail.at';
        $user->phone = '+43 660 453 35 02';
        $user->password = bcrypt('test1234!');
        $user->address_id = 4;
        $user->vaccination_id = 1;
        $user->save();
    }
}

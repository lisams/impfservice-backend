<?php

namespace Database\Seeders;

use App\Models\User;
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
    }
}

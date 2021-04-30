<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vaccination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return User::with(['address'])->get();
    }

    public function findBySVNR(string $svnr): User
    {
        $user = User::where('sv_nr', $svnr)
            ->with(['address'])
            ->first();
        return $user;
    }

    public function checkIfVaccinated(string $svnr)
    {
        $user = User::where('sv_nr', $svnr)->with(['address'])->first();
        if ($user != null) {
            return $user->vaccinated == true ? response()->json(true, 200) : response()->json(false, 200);
        } else {
            return response()->json("user with svnr " . $svnr . " does not exist", 200);
        }
    }

    public function update(Request $request, string $svnr)
    {
        return "test";
        /*DB::beginTransaction();
        try {

            $user = User::where('sv_nr', $svnr)
                ->with(['address'])
                ->first();
            $user->update([
                    'sv_nr' => $request['sv_nr'],
                    'date_of_birth' => $request['date_of_birth'],
                    'firstname' => $request['firstname'],
                    'lastname' => $request['lastname'],
                    'gender' => $request['gender'],
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                    'vaccinated' => $request['vaccinated']
                ]
            );
            $user->save();

            DB::commit();
            $user1 = User::where('sv_nr', $svnr)
                ->with(['address'])
                ->first();
            return response()->json($user1, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("updating user failed: " . $e->getMessage(), 420);
        }*/
    }

    public function remove(string $svnr)

    {
        $user = User::where('sv_nr', $svnr)
            ->with(['address'])
            ->first();
        if ($user != null) {
            /*$users = User::where('vaccination_id', $id)->get();
            if ($users->count() > 1) {
                foreach ($users as $user) {
                    $user->vaccination_id = NULL;
                    $user->save();
                }
            } else if ($users->count() == 1) {
                $users->first()->vaccination_id = NULL;
                $users->first()->save();
            }
            $vacc->delete();*/

            $user->delete();

        } else {
            return response()->json("user (" . $svnr . ") does not exist", 200);
        }
        return response()->json('user (' . $svnr . ') successfully deleted');
    }

}

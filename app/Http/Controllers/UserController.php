<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /** READ all users */
    public function index()
    {
        return User::with(['address'])->get();
    }

    /** READ single user by svnr */
    public function findBySVNR(string $svnr): User
    {
        $user = User::where('sv_nr', $svnr)
            ->with(['address'])
            ->first();
        return $user;
    }

    // TODO
    /** CREATE new user */
    public function createUser(Request $request): JsonResponse {

    }

    /** UPDATE user and register for caccination */
    public function registerForVaccination(string $svnr, string $vaccId): JsonResponse
    {
        DB::beginTransaction();
        try {
            // TODO check if vaccination available
            $user = User::where('sv_nr', $svnr)
                ->with(['address'])
                ->first();
            $user->update(['vaccination_id' => $vaccId]);
            $user->save();

            DB::commit();
            $user1 = User::where('sv_nr', $svnr)
                ->with(['address'])
                ->first();
            return response()->json($user1, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("updating user failed: " . $e->getMessage(), 420);
        }
    }

    /** UPDATE user and cancel vaccination registration */
    public function cancelForVaccination(string $svnr) : JsonResponse {
        DB::beginTransaction();
        try {
            $user = User::where('sv_nr', $svnr)
                ->with(['address'])
                ->first();
            $user->update(['vaccination_id' => null]);
            $user->save();

            DB::commit();
            $user1 = User::where('sv_nr', $svnr)
                ->with(['address'])
                ->first();
            return response()->json($user1, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("updating user failed: " . $e->getMessage(), 420);
        }
    }

    /** UPDATE user*/
    public function update(Request $request, string $svnr) : JsonResponse
    {
        DB::beginTransaction();
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
        }
    }

    /** UPDATE user and change vaccination status */
    public function updateVaccinationStatus(string $svnr) : JsonResponse
    {
        DB::beginTransaction();
        try {

            $user = User::where('sv_nr', $svnr)
                ->with(['address'])
                ->first();
            $status = !$user->vaccinated;
            $user->update([
                    'vaccinated' => $status
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
            return response()->json("updating user status failed: " . $e->getMessage(), 420);
        }
    }

    /** DELETE user by svnr */
    public function remove(string $svnr) : JsonResponse {
        $user = User::where('sv_nr', $svnr)
            ->with(['address'])
            ->first();
        if ($user != null) {
            $user->delete();
        } else {
            return response()->json("user (" . $svnr . ") does not exist", 200);
        }
        return response()->json('user (' . $svnr . ') successfully deleted');
    }

}

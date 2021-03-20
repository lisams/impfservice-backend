<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index() {
        return User::with(['address'])->get();
    }

    public function findBySVNR(string $svnr): User {
        $user = User::where('sv_nr', $svnr)
            ->with(['address'])
            ->first();
        return $user;
    }

    public function checkIfVaccinated(string $svnr) {
        $user = User::where('sv_nr', $svnr)->with(['address'])->first();
        if($user != null) {
            return $user->vaccinated == true ? response()->json(true, 200) : response()->json(false, 200);
        } else {
            return response()->json("user with svnr " . $svnr . " does not exist", 200);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return User::with(['address'])->get();
    }

    public function findBySVNR(string $svnr): User {
        $user = User::where('sv_nr', $svnr)
            ->with(['address'])
            ->first();
        return $user;
    }
}

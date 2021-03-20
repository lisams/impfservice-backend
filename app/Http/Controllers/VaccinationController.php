<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    public function index() {
        return Vaccination::with(['location', 'users'])->get();
    }

    public function findByID(string $id): Vaccination {
        $vacc = Vaccination::where('id', $id)
            ->with(['location', 'users'])
            ->first();
        return $vacc;
    }
}

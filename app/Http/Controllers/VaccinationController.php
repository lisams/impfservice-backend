<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function getOpenSlots(string $id) {
        $maxParticipants = Vaccination::where('id', $id)
            ->with(['users'])->first()->max_participants;
        $participants = DB::table('vaccinations')
            ->join('users', 'users.vaccination_id', '=', 'vaccinations.id')
            ->where('vaccinations.id', $id)
            ->count();
        return response($maxParticipants - $participants, 200);

        // SELECT COUNT(*)
        // FROM vaccinations
        // INNER JOIN users ON vaccinations.id = users.vaccination_id
        // WHERE (vaccinations.id=xy)
    }
}

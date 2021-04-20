<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vaccination;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaccinationController extends Controller
{
    public function index()
    {
        return Vaccination::with(['location', 'users'])->get();
    }

    public function findByID(string $id): Vaccination
    {
        $vacc = Vaccination::where('id', $id)
            ->with(['location', 'users'])
            ->first();
        return $vacc;
    }

    public function getOpenSlots(string $id)
    {
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

    public function remove(string $id): JsonResponse
    {
        $vacc = Vaccination::where('id', $id)
            ->with(['location'])
            ->first();
        if ($vacc != null) {
            $users = User::where('vaccination_id', $id)->get();
            if ($users->count() > 1) {
                foreach ($users as $user) {
                    $user->vaccination_id = NULL;
                    $user->save();
                }
            } else if ($users->count() == 1) {
                $users->first()->vaccination_id = NULL;
                $users->first()->save();
            }
            $vacc->delete();
        } else {
            return response()->json("vaccination (" . $id . ") does not exist", 200);
        }
        return response()->json('vaccination (' . $id . ') successfully deleted');
    }
}

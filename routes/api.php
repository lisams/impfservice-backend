<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaccinationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// vaccinations
Route::get('vaccinations', [VaccinationController::class, 'index']);
Route::get('vaccination/{id}', [VaccinationController::class, 'findByID']);
Route::get('vaccination/openslots/{id}', [VaccinationController::class, 'getOpenSlots']);
Route::post('vaccination/', [VaccinationController::class, 'create']);
Route::put('vaccination/{id}', [VaccinationController::class, 'update']);
Route::delete('vaccination/{id}', [VaccinationController::class, 'remove']);

// users
Route::get('users', [UserController::class, 'index']);
Route::get('user/{svnr}', [UserController::class, 'findBySVNR']);
Route::get('user/checkvaccination/{svnr}', [UserController::class, 'checkIfVaccinated']);

// locations
Route::get('locations', [LocationController::class, 'index']);
Route::get('location/{zip}', [LocationController::class, 'findByZIP']);

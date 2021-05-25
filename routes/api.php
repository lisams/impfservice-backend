<?php

use App\Http\Controllers\AddressController;
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

// auth
Route::post('auth/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('auth/logout', [App\Http\Controllers\AuthController::class, 'logout']);

// vaccinations
Route::get('vaccinations', [VaccinationController::class, 'index']);
Route::get('vaccinations/upcoming', [VaccinationController::class, 'getUpcomingVaccinations']);
Route::get('vaccinations/openslots', [VaccinationController::class, 'getUpcomingVaccinationsOpenSlots']);
Route::get('vaccination/{id}', [VaccinationController::class, 'findVaccinationById']);
Route::post('vaccination', [VaccinationController::class, 'createVaccination']);
Route::put('vaccination/{id}', [VaccinationController::class, 'updateVaccinationById']);
Route::delete('vaccination/{id}', [VaccinationController::class, 'removeVaccinationById']);

// users
Route::get('users', [UserController::class, 'index']);
Route::get('user/{svnr}', [UserController::class, 'findBySVNR']);
Route::put('user/{svnr}', [UserController::class, 'update']);
Route::put('user/register/{svnr}/{vaccId}', [UserController::class, 'registerForVaccination']);
Route::put('user/cancel/{svnr}', [UserController::class, 'cancelForVaccination']);
Route::put('user/status/{svnr}', [UserController::class, 'updateVaccinationStatus']);
Route::delete('user/{svnr}', [UserController::class, 'remove']);

// locations
Route::get('locations', [LocationController::class, 'index']);
Route::get('location/{id}', [LocationController::class, 'findLocationById']);
Route::put('location/{id}', [LocationController::class, 'updateLocationById']);
Route::post('location', [LocationController::class, 'createLocation']);
Route::delete('location/{id}', [LocationController::class, 'removeLocationById']);

// addresses
Route::get('addresses', [AddressController::class, 'index']);
Route::get('address/{id}', [AddressController::class, 'findAddressById']);
Route::put('address/{id}', [AddressController::class, 'updateAddressById']);
Route::post('address', [AddressController::class, 'createAddress']);
Route::delete('address/{id}', [AddressController::class, 'removeAddressById']);

Route::group(['middleware' => ['api', 'auth.jwt']], function() {
    Route::post('address', [AddressController::class, 'createAddress']);
    Route::delete('address/{id}', [AddressController::class, 'removeAddressById']);
});

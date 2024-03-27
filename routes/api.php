<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\VisitingListController;

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

/** ---------Register and Login ----------- */
Route::controller(RegisterController::class)->group(function()
{
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('users', 'login')->name('index');

});

/** -----------Users --------------------- */
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/users',[RegisterController::class,'index'])->name('index');
});

Route::middleware('auth:sanctum')->controller(RegisterController::class)->group(function() {
    Route::get('/users','index')->name('index');
});

Route::middleware('auth:sanctum')->post('/itineraries', [ItineraryController::class ,'store']);
Route::post('/itineraries/{itiniraireId}/destinations', [DestinationController::class, 'store']);
Route::put('/itineraries/{itiniraireId}', [ItineraryController::class, 'update']);
Route::post('/visiting-lists/{visiting_list}/itineraries/{itinerary}', [VisitingListController::class, 'addToVisitingList']);
Route::get('/itineraries', [ItineraryController::class, 'index']);
Route::get('/itineraries', [ItineraryController::class, 'filtre']);

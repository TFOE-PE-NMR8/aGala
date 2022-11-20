<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'clubs'], function(){
    Route::get('/all', [App\Http\Controllers\ClubController::class, 'getAll']);
});

Route::group(['prefix' => 'registrants'], function(){
    Route::group(['prefix' => 'datatable'], function(){
        Route::get('/', [\App\Http\Controllers\RegistrantController::class, 'getRegistrantsDataTable'])->name('api.registrants.datatable');
    });
});



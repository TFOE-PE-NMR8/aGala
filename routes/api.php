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

Route::group(['middleware' => 'auth'], function(){

    Route::group(['prefix' => 'registrants'], function(){
        Route::group(['prefix' => 'datatable'], function(){
            Route::get('/', [\App\Http\Controllers\RegistrantController::class, 'getRegistrantsDataTable'])->name('api.registrants.datatable');
        });
    });

    //POST URL: api/registration/pay
    Route::post('/registration/pay', [\App\Http\Controllers\RegistrationController::class, 'pay'])->name('api.registration.pay');

    Route::group(['prefix' => 'guests'], function(){
        Route::group(['prefix' => 'datatable'], function(){
            //URL: api/guests/datatable?registrant={id}
            Route::get('/', [\App\Http\Controllers\GuestController::class, 'getGuestsDataTable'])->name('api.guests.datatable');
        });
    });
    Route::group(['prefix' => 'payment-logs'], function(){
        Route::group(['prefix' => 'data'], function(){
            //URL: api/payment-logs/data
            Route::get('/', [\App\Http\Controllers\PaymentLogController::class, 'log_data'])->name('api.payload_logs.data');
        });
    });
});




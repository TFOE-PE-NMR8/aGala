<?php

use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $total = Registration::whereColumn('total_amount', 'paid_amount')->sum('quantity');
    return view('index')->with('total_guests', $total);
});

Route::get('/registration', [App\Http\Controllers\RegistrationController::class, 'registration'])->name('registration');
Route::post('/registration', [App\Http\Controllers\RegistrationController::class, 'register'])->name('register');
Route::get('/registered/{reference_number}', [App\Http\Controllers\RegistrationController::class, 'registered'])->name('registered');
Route::get('/registered/{id}/dlqr', [App\Http\Controllers\RegistrationController::class, 'dowloadQRCode']);

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/registrants', [App\Http\Controllers\RegistrantController::class, 'index'])->name('registrants');
    Route::get('/payment-logs', [App\Http\Controllers\PaymentLogController::class, 'index'])->name('payment_logs');
    Route::get('/guests', [App\Http\Controllers\GuestController::class, 'index'])->name('guests');
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

    Route::get('/attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance');
    Route::get('/scanQr/{qr_code}', [App\Http\Controllers\AttendanceController::class, 'scanQr'])->name('scanQr');
    Route::post('/attend/{status}/{id}', [App\Http\Controllers\AttendanceController::class, 'attend'])->name('attend');

    Route::get('/listOfAttend', [App\Http\Controllers\AttendanceController::class, 'listOfAttend'])->name('listOfAttend');

    Route::get('/raffle', [App\Http\Controllers\RaffleController::class, 'index']);
    Route::post('/raffle/winner', [App\Http\Controllers\RaffleController::class, 'update']);
    Route::get('/raffle/raffle-100', [App\Http\Controllers\RaffleController::class, 'raffle_100']);
    Route::get('/raffle/raffle-main', [App\Http\Controllers\RaffleController::class, 'raffle_main']);
    Route::get('/raffle/raffle-main-generate', [App\Http\Controllers\RaffleController::class, 'generate_main_entry']);
    Route::get('/raffle/raffle-100-generate', [App\Http\Controllers\RaffleController::class, 'generate_100_entry']);
    
    Route::group(['middleware' => ['role:admin']],function() { 
        // Route::resource('users','UsersController'); 
        Route::get('/list-users', [App\Http\Controllers\UsersController::class, 'index']);   
        Route::post('/create_users', [App\Http\Controllers\UsersController::class, 'store']);
        Route::get('/users/{id}/edit', [App\Http\Controllers\UsersController::class, 'edit']);
        Route::post('/users/{id}/delete', [App\Http\Controllers\UsersController::class, 'delete']);
        Route::post('/usersEdit/{id}', [App\Http\Controllers\UsersController::class, 'update']);
    
    
        Route::get('/list-roles', [App\Http\Controllers\RolesController::class, 'index']); 
        Route::post('/create_roles', [App\Http\Controllers\RolesController::class, 'store']);              
    });
   
    

});

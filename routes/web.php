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
    $data = Registration::where('is_paid', true)->with('registrant')->get();
    $total = 0;
    foreach ($data as $item) {
        $total += $item->registrant->quantity;
    }
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
    Route::get('/guests', [App\Http\Controllers\GuestController::class, 'index'])->name('guests');
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
});



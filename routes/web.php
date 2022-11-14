<?php

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
    return view('welcome');
});

Route::get('/registration', [App\Http\Controllers\RegistrationController::class, 'registration'])->name('registration');
Route::post('/register', [App\Http\Controllers\RegistrationController::class, 'register'])->name('register');
Route::get('/registered', [App\Http\Controllers\RegistrationController::class, 'registered'])->name('registered');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



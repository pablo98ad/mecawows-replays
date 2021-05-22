<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

use App\Http\Controllers\Api\Auth\LoginController;


Auth::routes();

Passport::routes();
Route::post('/login', [LoginController::Class, 'login'])->name('login.api')->middleware('web');

Route::get('/login', function () {
    return view('index');
})->name('login.api');

Route::get('/register', function () {
    return view('index');
})->name('register.api');

Route::get( '/{any}', function () {
    return view('index');
})->where('any', '.*');


<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'auth'])->name('login.auth');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::namespace('Admin')->group(function () {
        Route::get('home', [App\Http\Controllers\Admin\HomeController::class, 'home'])->name('admin.home');
    });
});

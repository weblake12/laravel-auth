<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\HomeController As AdminHomeController;
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

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::namespace('Admin')->group(function () {
        Route::get('home', [AdminHomeController::class, 'home'])->name('admin.home');
    });
});

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


Route::get('home', 'HomeController@home')->name('home');
Route::get('login', 'LoginController@login')->name('login');
Route::post('login', 'LoginController@auth')->name('login.auth');


Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::namespace('Admin')->group(function () {
        Route::get('home', 'HomeController@home')->name('admin.home');
    });
});

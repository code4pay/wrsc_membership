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

Route::resource('application', '\App\Http\Controllers\ApplicationController');
Route::resource('tac_accept', '\App\Http\Controllers\TacsController');
Route::post('email_renewals', '\App\Http\Controllers\EmailRenewalsController@emailRenewals');




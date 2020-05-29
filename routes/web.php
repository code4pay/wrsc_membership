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
Route::post('admin/email_renewals', '\App\Http\Controllers\EmailRenewalsController@emailRenewals')->middleware('auth');
Route::post('print_renewals', '\App\Http\Controllers\EmailRenewalsController@printRenewals')->middleware('auth');
Route::post('admin/email_membership_card', '\App\Http\Controllers\MembershipCardController@emailMembershipCard')->middleware('auth');
Route::post('print_membership_card', '\App\Http\Controllers\MembershipCardController@printMembershipCard')->middleware('auth');
Route::get('profile_images/{fileName}', '\App\Http\Controllers\ProfileImagesController@showImage')->middleware('auth');
Route::get('card/profile_images/{fileName}', '\App\Http\Controllers\ProfileImagesController@showImage')->middleware('local_address'); //this is so pdf generator can access images only from 127.0.0.1




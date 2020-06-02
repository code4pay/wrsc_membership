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
// these  routes are not authed, but use a token
Route::post('paid_paypal', '\App\Http\Controllers\TacsController@paidPayPal'); 
//Route::get('tac_accept/{tokenValue}', '\App\Http\Controllers\TacsController@show');
//Route::put('tac_accept', '\App\Http\Controllers\TacsController@update');
Route::resource('tac_accept', '\App\Http\Controllers\TacsController');
Route::get('dont_renew/{tokenValue}', '\App\Http\Controllers\TacsController@dontRenewShow');
Route::put('dont_renew/{tokenValue}', '\App\Http\Controllers\TacsController@didntRenew');

Route::post('admin/email_renewals', '\App\Http\Controllers\EmailRenewalsController@emailRenewals')->middleware('auth');
Route::post('print_renewals', '\App\Http\Controllers\EmailRenewalsController@printRenewals')->middleware('auth');
Route::post('admin/email_membership_card', '\App\Http\Controllers\MembershipCardController@emailMembershipCard')->middleware('auth');
Route::post('print_membership_card', '\App\Http\Controllers\MembershipCardController@printMembershipCard')->middleware('auth');
Route::get('profile_images/{fileName}', '\App\Http\Controllers\ProfileImagesController@showImage')->middleware('auth'); //protect profile images. 
Route::get('card/profile_images/{fileName}', '\App\Http\Controllers\ProfileImagesController@showImage')->middleware('local_address'); //this is so pdf generator can access images only from 127.0.0.1
Route::get('/',function () {
    return redirect('/admin');
});




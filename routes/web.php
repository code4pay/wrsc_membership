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

// Uncomment these on when ready to turn on Applications 
// Route::resource('application', '\App\Http\Controllers\MembershipApplicationController');
// Route::post('id_upload', '\App\Http\Controllers\MembershipApplicationController@id_upload')->name('id_upload');

// these  routes are not authed, but use a one time token
Route::post('paid_paypal', '\App\Http\Controllers\RenewalController@paidPayPal'); 
Route::resource('tac_accept', '\App\Http\Controllers\RenewalController');
Route::get('dont_renew/{tokenValue}', '\App\Http\Controllers\RenewalController@dontRenewShow');
Route::put('dont_renew/{tokenValue}', '\App\Http\Controllers\RenewalController@didntRenew');

Route::post('admin/email_renewals', '\App\Http\Controllers\RenewalController@emailRenewals')->middleware('auth');
Route::post('print_renewals', '\App\Http\Controllers\RenewalController@printRenewals')->middleware('auth');
Route::post('admin/email_membership_card', '\App\Http\Controllers\MembershipCardController@emailMembershipCard')->middleware('auth');
Route::post('print_membership_card', '\App\Http\Controllers\MembershipCardController@printMembershipCard')->middleware('auth');
Route::get('profile_images/{fileName}', '\App\Http\Controllers\ProfileImagesController@showImage')->middleware('auth'); //protect profile images. 
Route::get('private/documents/{fileName}', '\App\Http\Controllers\DocumentsController@download')->middleware('auth'); //protect documents.
Route::get('card/profile_images/{fileName}', '\App\Http\Controllers\ProfileImagesController@showImage')->middleware('local_address'); //this is so pdf generator can access images only from 127.0.0.1
Route::get('/',function () {
    return redirect('/admin');
});




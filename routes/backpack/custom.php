<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web','role:admin', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('course', 'CourseCrudController');
    Route::crud('region', 'RegionCrudController');
    Route::crud('membershiptype', 'MembershiptypeCrudController');
    Route::crud('authority', 'AuthorityCrudController');
    Route::get('user/email/{user}', '\app\Http\Controllers\UserCrudController@email');
    Route::crud('email_template', 'EmailTemplateCrudController');
}); // this should be the absolute last line of this file

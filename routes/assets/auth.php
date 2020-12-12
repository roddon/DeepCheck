<?php
Route::get('login', 'AuthenticateController@create')->name('auth.login');
Route::post('login', 'AuthenticateController@login')->name('auth.login.post');
Route::post('logout', 'AuthenticateController@logout')->name('auth.logout');

Route::post('store', 'AuthenticateController@store')->name('auth.store');
// Route::get('forgot-password', 'AuthenticateController@forgotPasswordCreate')->name('auth.forgot-password');
Route::post('forgot-password', 'AuthenticateController@forgotPassword')->name('auth.forgot-password.post');


Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::get('/', 'AuthenticateController@create')->name('login');
    Route::post('login', 'AuthenticateController@adminLogin')->name('login.post');
});

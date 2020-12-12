<?php

use App\Http\Controllers\UserController;

Route::post('change-password', 'UserController@changePassword')->name('users.change.password');
Route::post('update', 'UserController@update')->name('users.update');
Route::post('payment-plan', 'UserController@paymentPlan')->name('users.payment-plan');

<?php
Route::post('login', 'Api\AuthController@login')->name('login');

Route::post('logout', 'Api\AuthController@login')->name('logout');

Route::middleware('auth:api')->post('/user/update', 'Api\UserController@update')->name('user.update');

Route::middleware('auth:api')->post('/user/userDetailBySftpToken', 'Api\UserController@userDetailBySftpToken')->name('user.userDetailBySftpToken');
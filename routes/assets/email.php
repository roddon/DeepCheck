<?php
Route::post('email/read', 'EmailLogController@read')->name('email.read');
Route::resource('email', 'EmailLogController', ['name' => 'email']);

<?php


Route::get('institution-list', 'VerificationController@getInstitutions')
    ->name('institution-list');

Route::post('account-auth-request', 'VerificationController@accountAuthRequest')
    ->name('account-auth-request');

Route::group([
    'prefix' => 'customer',
    'as' => 'customer.'
], function () {
    Route::post('/add-account/', 'VerificationController@addCustomerAccount')
        ->name('add-account');

    Route::get('kyc/{customer_id}', 'VerificationController@kycVerification')
        ->name('kyc');

    Route::get('/callback/{code}/{credentialsId}', 'VerificationController@tinkCallback')
        ->name('tink-callback');

    Route::post('/add-address/', 'VerificationController@addCustomerAddress')
        ->name('add-address');
});

Route::group([
    'prefix' => 'supplier',
    'as' => 'supplier.'
], function () {
    Route::get('{verification_code}', 'VerificationController@startSupplierVerification')
        ->name('start');

    Route::post('verify-otp', 'VerificationController@verifyPhoneOtp')->name('verify-otp');

    Route::post('update', 'VerificationController@updateSupplier')
        ->name('update');


    Route::get('kyc/{supplier_id}', 'VerificationController@kycVerification')
        ->name('kyc');

    Route::get('/callback/{code}/{credentialsId}', 'VerificationController@tinkCallback')
        ->name('tink-callback');

    Route::post('/add-account/', 'VerificationController@addSupplierAccount')
        ->name('add-account');

    Route::post('/add-address/', 'VerificationController@addSupplierAddress')
        ->name('add-address');
});


Route::group([
    'prefix' => 'user',
    'as' => 'user.'
], function () {
    Route::get('{verification_code}', 'AuthenticateController@startUserVerification')
        ->name('start');

    Route::post('verify-otp', 'AuthenticateController@verifyPhoneOtp')->name('verify-otp');
});

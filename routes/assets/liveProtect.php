<?php
Route::post('paymentRequest', 'LiveProtectController@paymentRequest')->name('liveProtect.payment-request');
Route::post('paymentRequestDuedate', 'LiveProtectController@paymentRequest')->name('liveProtect.payment-request-duedate');
Route::get('/', 'LiveProtectController@index')->name('liveProtect.index');
Route::get('callback', 'LiveProtectController@callback')->name('liveProtect.callback');
Route::get('paymentResult', 'LiveProtectController@paymentResult')->name('liveProtect.paymentResult');

// Route::resource('/', 'LiveProtectController', ['name' => 'liveProtect']);


Route::group([
    'prefix' => 'payments',
    'as' => 'liveProtect.payments.'
], function () {
    Route::get('institutions', 'SettingController@getInstitutions')->name('institutions');
    Route::post('payment-auth-create', 'SettingController@createPaymentConsentToken')->name('payment-auth-create');

    Route::get('consent-callback', 'SettingController@makePayment')->name('consent-callback');

    Route::post('payment-callback', function () {
    })->name('payment-callback');
});

<?php
Route::get('/', 'OnboardingController@index')->name('onboarding.index');
Route::post('/send-mail', 'OnboardingController@sendMail')->name('onboarding.send-mail');

Route::get('/dashboard', 'OnboardingController@dashboard')
    ->name('onboarding.customer-verification');


Route::get('/tink-account-verification', 'OnboardingController@accountVerification')
    ->name('onboarding.tink-account-verification');

Route::get('/callback', 'OnboardingController@tinkCallback')
    ->name('onboarding.tink-callback');

Route::get('/customer-detail/{id}', 'OnboardingController@customerDetail')
    ->name('onboarding.customer-detail');

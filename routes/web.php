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




Route::get('/', 'AppController@home')->name('home');


Route::get('customer-verification/{verification_code}', 'OnboardingController@customerVerification')
    ->name('customer-verification');

Route::get('kyc-verification/{customer_id}', 'OnboardingController@kycVerification')
    ->name('kyc-verification');

Route::post('check-customer-varification', 'OnboardingController@checkCustomerVerification')
    ->name('check-customer-verification');

Route::post('check-supplier-varification', 'SupplierController@checkSupplierVerification')
    ->name('check-supplier-verification');

Route::post('/supplier-upload-document', 'SupplierController@uploadDocument')
    ->name('supplier.upload-document');
    
// Route::get('/callback', 'OnboardingController@tinkCallback')
//     ->name('tink-callback');

Route::post('/upload-document', 'OnboardingController@uploadDocument')
    ->name('onboarding.upload-document');
Route::post('onboarding-verify-otp', 'OnboardingController@verifyPhoneOtp')->name('onboarding.verify-phone-number');


Route::get('/callback', 'AppController@tinkCallback')
    ->name('tink-callback');

Route::get('about-us', function () {
    $bodyClass = 'account-page';
    $title = 'About Us';
    $siteSeo = config('config.seo.about_us_page');
    return view('manage.frontend.about-us', compact('bodyClass', 'title', 'siteSeo'));
})->name('about-us');

Route::get('safe-pay', function () {
    $bodyClass = 'safepay-page';
    $title = 'SafePay';
    $siteSeo = config('config.seo.safe_pay_page');
    return view('manage.frontend.safepay', compact('bodyClass', 'title', 'siteSeo'));
})->name('safe-pay');


Route::get('document-check', function () {
    $bodyClass = 'document-page';
    $title = 'Document, Invoice and Supplier Check';
    $siteSeo = config('config.seo.check_invoice_page');
    return view('manage.frontend.document-check', compact('bodyClass', 'title', 'siteSeo'));
})->name('document-check');

Route::get('account-check', function () {
    $bodyClass = 'account-page';
    $title = 'Internal Fraud Check';
    $siteSeo = config('config.seo.internal_fraud_page');
    return view('manage.frontend.account-check', compact('bodyClass', 'title', 'siteSeo'));
})->name('account-check');

Route::get('identity-check', function () {
    $bodyClass = 'account-page id-page';
    $title = 'Onboarding';
    $siteSeo = config('config.seo.identity_check_page');
    return view('manage.frontend.identity-check', compact('bodyClass', 'title', 'siteSeo'));
})->name('identity-check');


Route::get('technology', function () {
    $bodyClass = 'technology-page';
    $title = 'Technology';
    $siteSeo = config('config.seo.technology_page');
    return view('manage.frontend.technology', compact('bodyClass', 'title', 'siteSeo'));
})->name('technology');

Route::get('terms-and-conditions', function () {
    $bodyClass = 'account-page';
    $title = 'Terms And Condition';
    $siteSeo = config('config.seo.terms_and_condition_page');
    return view('manage.frontend.terms-and-conditions', compact('bodyClass', 'title', 'siteSeo'));
})->name('terms-and-conditions');

Route::get('privacy-policy', function () {
    $bodyClass = 'account-page';
    $title = 'Privacy Policy';
    $siteSeo = config('config.seo.privacy_policy_page');
    return view('manage.frontend.privacy-policy', compact('bodyClass', 'title', 'siteSeo'));
})->name('privacy-policy');


Route::post('check-invoice', 'UserController@checkInvoice')->name('check-invoice');
Route::post('verify-otp-code', 'UserController@verifyOtpCode')->name('verify-otp-code');

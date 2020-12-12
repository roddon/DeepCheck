<?php

Route::post('/upload-logo-image', 'CompanyController@uploadImage')
    ->name('company.upload-logo-image');

Route::post('/company-number-verify', 'CompanyController@companyNumberVerify')
    ->name('company.company-number-verify');

Route::post('/vat-number-verify', 'CompanyController@vatNumberVerify')
    ->name('company.vat-number-verify');

Route::post('/iban-number-verify', 'CompanyController@ibanNumberVerify')
    ->name('company.iban-number-verify');

Route::post('/update', 'CompanyController@update')
    ->name('company.update');

Route::post('/add-special-customer', 'CompanyController@addSpecialCustomer')
    ->name('company.add-special-customer');

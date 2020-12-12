<?php

Route::get('/update-customer-sanction-list/{id}', 'OnboardingController@updateCustomerSanctionList')
    ->name('onboarding.updateCustomerSanctionList');
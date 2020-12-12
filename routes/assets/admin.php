<?php


Route::group([
    'prefix' => 'users',
    'as' => 'users.'
], function () {
    Route::get('/', 'UsersController@index')->name('index');
    Route::get('/create', 'UsersController@create')->name('create');
    Route::post('/store', 'UsersController@store')->name('store');
    Route::get('/edit/{id}', 'UsersController@edit')->name('edit');
    Route::post('/update/{id}', 'UsersController@update')->name('update');
});

Route::group([
    'prefix' => 'members',
    'as' => 'members.'
], function () {
    Route::get('/', 'MembersController@index')->name('index');
    Route::get('/create', 'MembersController@create')->name('create');
    Route::post('/store', 'MembersController@store')->name('store');
    Route::get('/edit/{id}', 'MembersController@edit')->name('edit');
    Route::post('/update/{id}', 'MembersController@update')->name('update');
});

Route::group(
    [
        'prefix' => 'subscription-plans',
        'as' => 'subscription_plans.'
    ],
    function () {
        Route::get('/', 'SubscriptionPlanController@index')->name('index');
        Route::get('/create', 'SubscriptionPlanController@create')->name('create');
        Route::post('/store', 'SubscriptionPlanController@store')->name('store');
        Route::get('/edit/{id}', 'SubscriptionPlanController@edit')->name('edit');
        Route::patch('/update/{id}', 'SubscriptionPlanController@update')->name('update');
    }
);

Route::get('activity-log', 'ActivityLogController@index')->name('activityLog.index');

Route::get('tink-log', 'TinkLogController@index')->name('tinkLog.index');

Route::get('true-layer-log', 'TrueLayerLogController@index')->name('trueLayerLog.index');

Route::get('stripe-log', 'StripeLogController@index')->name('stripeLog.index');

Route::get('customer-log', 'CustomerLogController@index')->name('customerLog.index');

Route::get('plan-counter-log', 'StripeLogController@counterLog')->name('counterLog.index');

Route::group([
    'prefix' => 'change-request'
], function () {
    Route::get('/', 'ChangeRequestController@index')->name('change-request.index');
    Route::get('/editInvoiceMedia/{invoiceId}', 'ChangeRequestController@editInvoiceMedia')->name('change-request.editInvoiceMedia');
    Route::post('/updateInvoiceMediaStatus', 'ChangeRequestController@updateInvoiceMediaStatus')->name('change-request.updateInvoiceMediaStatus');
    Route::post('/updateInvoiceMedia', 'ChangeRequestController@updateInvoiceMedia')->name('change-request.updateInvoiceMedia');
    Route::post('/update-invoice-media-items', 'ChangeRequestController@updateInvoiceMediaItems')->name('change-request.update-invoice-media-items');
});
<?php

Route::get('accounting-check', 'DetectorController@accountingCheck')->name('detector.accountingCheck');
Route::post('accounting-sync', 'DetectorController@accountingSync')->name('detector.accountingSync');
Route::get('accounting-check-mautic', 'DetectorController@checkAccountingForMautic')->name('detector.checkAccountingForMautic');


Route::group([
    'prefix' => 'connectors',
    'as' => 'detector.connectors.'
], function () {
    Route::get('return', 'DetectorController@connectorCallback')
        ->name('return');

    Route::post('import-callback', 'DetectorController@connectorCallback')
        ->name('import-callback');
});

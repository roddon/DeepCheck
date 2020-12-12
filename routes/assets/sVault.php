<?php

Route::get('suppliers', 'SupplierController@index')->name('sVault.supplier.list');
Route::post('suppliers/invite', 'SupplierController@inviteSupplier')->name('sVault.supplier.invite');
Route::get('suppliers/verification/{supplier_id?}/{invoice_id?}', 'SupplierController@verification')->name('sVault.supplier.verification');
Route::get('suppliers/export', 'SupplierController@export')->name('sVault.supplier.export');
Route::post('suppliers/import', 'SupplierController@import')->name('sVault.supplier.import');
Route::post('suppliers/invite-by-email', 'SupplierController@invite')->name('sVault.supplier.invite-by-email');


Route::post('suppliers/invoice', 'SupplierController@getInvoiceDetail')->name('sVault.supplier.invoice.detail');

Route::get('suppliers/edit-invoice-media/{mediaId}/{invoiceId}', 'SupplierController@editInvoiceMedia')->name('sVault.supplier.edit-invoice-media');
Route::post('suppliers/update-invoice-media', 'SupplierController@updateInvoiceMedia')->name('sVault.supplier.update-invoice-media');
Route::post('suppliers/send-to-admin-review', 'SupplierController@sendToAdminReview')->name('sVault.supplier.send-to-admin-review');
Route::post('suppliers/update-invoice-media-items', 'SupplierController@updateInvoiceMediaItems')->name('sVault.supplier.update-invoice-media-items');
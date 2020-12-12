<?php
Route::get('invoice/supplier/{id}/{invoiceId?}', 'InvoiceController@supplierView')->name('invoice.supplier');

Route::get('invoice/{id}', 'InvoiceController@detail')->name('invoice.detail');
Route::get('suppliers/verification/{supplier_id?}/{invoice_id?}', 'SupplierController@verification')->name('invoice.verification');

Route::post('invoice/vrifyInvoice', 'InvoiceController@varifyInvoice')->name('varifyInvoice');
Route::get('invoice/supplierVarification', 'InvoiceController@supplierVarification')->name('supplierVarification');
Route::resource('invoice', 'InvoiceController', ['name' => 'invoice']);
Route::post('invoice/detail', 'InvoiceController@getInvoiceDetail')->name('invoice.get-detail');

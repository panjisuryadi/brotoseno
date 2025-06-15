<?php

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

Route::group(['middleware' => 'auth'], function () {

    //Generate PDF
    Route::get('/purchases/pdf/{id}', function ($id) {
        $purchase = \Modules\Purchase\Entities\Purchase::findOrFail($id);
        $supplier = \Modules\People\Entities\Supplier::findOrFail($purchase->supplier_id);

        $pdf = \PDF::loadView('purchase::print', [
            'purchase' => $purchase,
            'supplier' => $supplier,
        ])->setPaper('a4');

        return $pdf->stream('purchase-'. $purchase->reference .'.pdf');
    })->name('purchases.pdf');

    //Sales
    Route::resource('purchases', 'PurchaseController');

    Route::post('purchases/completepurchase', 'PurchaseController@completepurchase')->name('purchase.completepurchase');

    Route::post('purchases/savesupplier', 'PurchaseController@savetransferProduct')->name('purchases.savesupplier');


    Route::post('purchases/save-transfer-customer', 'PurchaseController@savetransferCustomer')->name('purchase.save.transfer.customer');

    //save type
    Route::post('purchases/save-customer', 'PurchaseController@saveTypeCustomer')->name('purchase.save.customer');

    //type
    Route::get('/purchase-type/{type}', 'PurchaseController@type')->name('purchase.type');



    Route::get('/purchase-product-add', 'PurchaseController@add')->name('purchase-product.add');


    Route::get('/purchase-product-index-data', 'PurchaseController@index_data')->name('purchase.index_data');

    Route::get('/purchase-history', 'PurchaseController@history')->name('purchase.history');

    Route::get('/index-purchase-type/{type}', 'PurchaseController@index_data_type')->name('purchase.index_data_type');

    Route::get('/purchase-index-table', 'PurchaseController@index_datatable')->name('purchase.index_datatable');

    //Payments
    Route::get('/purchase-payments/{purchase_id}', 'PurchasePaymentsController@index')->name('purchase-payments.index');


    Route::get('/purchase-payments/{purchase_id}/create', 'PurchasePaymentsController@create')->name('purchase-payments.create');
    Route::post('/purchase-payments/store', 'PurchasePaymentsController@store')->name('purchase-payments.store');
    Route::get('/purchase-payments/{purchase_id}/edit/{purchasePayment}', 'PurchasePaymentsController@edit')->name('purchase-payments.edit');
    Route::patch('/purchase-payments/update/{purchasePayment}', 'PurchasePaymentsController@update')->name('purchase-payments.update');
    Route::delete('/purchase-payments/destroy/{purchasePayment}', 'PurchasePaymentsController@destroy')->name('purchase-payments.destroy');

});

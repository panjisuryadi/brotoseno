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

    //POS
    Route::get('/app/pos', 'PosController@index')->name('app.pos.index');
    Route::post('/app/pos', 'PosController@store')->name('app.pos.store');

    //Generate PDF

    Route::get('/sales/pos/pdf/{id}', function ($id) {
        $sale = \Modules\Sale\Entities\Sale::findOrFail($id);

        $pdf = \PDF::loadView('sale::print-pos', [
            'sale' => $sale,
        ])->setPaper('a7')
            ->setOption('margin-top', 8)
            ->setOption('margin-bottom', 8)
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5);

        return $pdf->stream('sale-' . $sale->reference . '.pdf');
    })->name('sales.pos.pdf');


    //Custom
    Route::get('/custom', 'CustomController@index')->name('sale.custom.index');
    Route::get('/custom/create/{custom_id}', 'CustomController@create')->name('sale.custom.create');
    Route::post('/custom/store', 'CustomController@store')->name('sale.custom.store');
    Route::delete('/custom/destroy/{custom_id}', 'CustomController@destroy')->name('sale.custom.destroy');


    //Sales
    Route::post('sales/failed/{id}', 'SaleController@failed')->name('sales.failed'); //digunakan untuk set status dp yang jatuh tempo

    Route::get('sales/index_data', 'SaleController@index_data')
        ->name('sales.index_data');

    Route::get('sales/cetak/{id}', 'SaleController@cetak')
        ->name('sales.cetak');


    Route::get('sales/pdf/{id}', 'SaleController@pdf')
        ->name('sales.pdf');



    Route::get('sales/generate-invoice/{id}', 'SaleController@generateInvoice')
        ->name('sales.invoice');  

    Route::get('sales/export-sale-excel', 'SaleController@export_sale_excel')
        ->name('sales.export_sale_excel');

    Route::get('sales/show-cicilan/{id}', 'SaleController@show_cicilan')
        ->name('sales.show_cicilan');




    Route::resource('sales', 'SaleController');




    //Payments
    Route::get('/sale-payments/{sale_id}', 'SalePaymentsController@index')
        ->name('sale-payments.index');



    Route::get('/sale-payments/{sale_id}/create', 'SalePaymentsController@create')->name('sale-payments.create');
    Route::post('/sale-payments/store', 'SalePaymentsController@store')->name('sale-payments.store');
    Route::get('/sale-payments/{sale_id}/edit/{salePayment}', 'SalePaymentsController@edit')->name('sale-payments.edit');
    Route::patch('/sale-payments/update/{salePayment}', 'SalePaymentsController@update')->name('sale-payments.update');
    Route::delete('/sale-payments/destroy/{salePayment}', 'SalePaymentsController@destroy')->name('sale-payments.destroy');
});

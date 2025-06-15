<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes(['register' => false]);
Route::get('language/{language}', 'LanguageController@switch')->name('language.switch');



Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')
        ->name('home');  
    Route::get('/home/distribusi', 'HomeController@distribusi')
        ->name('home.distribusi');
    Route::get('/home/buys-backnota', 'HomeController@buysbacknota')
        ->name('home.buysbacknota');

    Route::get('/stockopname', 'StockOpnameController@list')
        ->name('stock_opname.list');

    Route::get('/stockopname/index_data/{id}', 'StockOpnameController@index_data')
        ->name('stock_opname.index_data');

    Route::get('/stockopname/index_riwayat', 'StockOpnameController@index_riwayat')
        ->name('stock_opname.index_riwayat');

    Route::get('/stockopname/index_hilang/{id}', 'StockOpnameController@index_hilang')
        ->name('stock_opname.index_hilang');

    Route::get('/stockopname/hilang', 'StockOpnameController@hilang')
        ->name('stock_opname.hilang');

    // Route::get('/stockopname/view/{id}', 'StockOpnameController@view')
    //     ->name('stock_opname.view');

    Route::get('/stockopname/detail/{id}', 'StockOpnameController@detail')
        ->name('stock_opname.detail');

    Route::get('/stockopname/baki/{id}', 'StockOpnameController@baki')
        ->name('stock_opname.baki');

    Route::get('/stockopname/detail/update/{id}/{product}', 'StockOpnameController@update')
        ->name('stock_opname.update');

    Route::post('/stockopname/update', 'StockOpnameController@update_new')
        ->name('stock_opname.update_new');

    Route::get('/stockopname/done/{id}', 'StockOpnameController@done')
        ->name('stock_opname.done');

    Route::post('/stockopname/detail/history', 'StockOpnameController@history')
        ->name('stock_opname.history');

    Route::get('/stockopname/data', 'StockOpnameController@data')
        ->name('stock_opname.data');

    Route::get('/stockopname/riwayat', 'StockOpnameController@riwayat')
        ->name('stock_opname.riwayat');

    Route::get('/stockopname/hilang/{id}', 'StockOpnameController@hilang')
        ->name('stock_opname.hilang');

    Route::get('/stockopname/detail_data/{id}', 'StockOpnameController@detail_data')
        ->name('stock_opname.detail_data');

    Route::get('/stockopname/opname_data/{id}', 'StockOpnameController@opname_data')
        ->name('stock_opname.opname_data');

    Route::get('/bakis', 'BakiController@list')
        ->name('bakis.list');

    Route::get('/bakis/index_data', 'BakiController@index_data')
        ->name('bakis.index_data');

    Route::post('/bakis', 'BakiController@insert')
        ->name('bakis.insert');

    Route::post('/bakis/update', 'BakiController@update')
        ->name('bakis.update');

    Route::get('/sales-purchases/chart-data', 'HomeController@salesPurchasesChart')
        ->name('sales-purchases.chart');

    Route::get('/current-month/chart-data', 'HomeController@currentMonthChart')
        ->name('current-month.chart');

    Route::get('/payment-flow/chart-data', 'HomeController@paymentChart')
        ->name('payment-flow.chart');

    Route::get('/sale', 'JualController@list')
        ->name('sale.list');

    Route::get('/sale/report', 'JualController@laporan')
        ->name('sale.report');

    Route::get('/sale/data_report', 'JualController@data_report')
        ->name('sale.data_report');
    
    Route::post('/sale/print', 'JualController@print')
        ->name('sale.print');

    Route::get('/dashboard', 'DashboardController@list')
        ->name('dashboard.index');

    Route::get('/pettycash', 'PettyCashController@list')
        ->name('pettycash.index');  

    Route::get('/webcam', 'WebcamController@list')
        ->name('webcam.index');
        
    Route::get('/webcam/update/{value}', 'WebcamController@update')
        ->name('webcam.update');
        
    Route::get('/pettycash/detail/{id}', 'PettyCashController@detail')
        ->name('pettycash.detail');  

    Route::post('/pettycash/insert', 'PettyCashController@insert')
        ->name('pettycash.insert');

    Route::post('/pettycash/update', 'PettyCashController@update')
        ->name('pettycash.update');

    Route::post('/pettycash/close', 'PettyCashController@close')
        ->name('pettycash.close');

    Route::get('/pettycash/index_data', 'PettyCashController@index_data')
        ->name('pettycash.index_data');
        
    Route::get('/pettycash/detail_data/{id}', 'PettyCashController@detail_data')
        ->name('pettycash.detail_data');
    
    Route::get('/config/index_data', 'ConfigController@index_data')
        ->name('config.index_data');

    Route::get('/config/nota', 'ConfigController@test_nota')
        ->name('config.nota');

    Route::get('/config', 'ConfigController@list')
        ->name('config.index');

    Route::post('/config/insert', 'ConfigController@insert')
        ->name('config.insert');

    Route::post('/config/update', 'ConfigController@update')
        ->name('config.update');

    Route::post('/config', 'ConfigController@create')
        ->name('config.create');

    Route::get('/buyback', 'BuyBackController@list')
        ->name('buyback.list');

    Route::get('/buyback/print/{id}', 'BuyBackController@print_struk')
        ->name('buyback.print');

    Route::get('/buyback_index_data', 'BuyBackController@index_data')
        ->name('buyback.index_data');

    Route::get('/buyback_nota/{id}', 'BuyBackController@view_nota')
        ->name('buyback.nota');

    Route::post('/buyback_insert', 'BuyBackController@insert')
        ->name('buyback.insert');

    Route::get('/product_history', 'HistoryProductsController@list')
        ->name('history_product.list');

    Route::get('/product_history_data', 'HistoryProductsController@product_data')
        ->name('history_product.product_data');

    Route::get('/test_pdf', 'JualController@test_pdf')
        ->name('sale.test_pdf');

    Route::get('/sale/index_data', 'JualController@index_data')
        ->name('sale.index_data');

    Route::get('/sale/index_data/{id}', 'JualController@index_data_custom')
        ->name('sale.index_data_custome');

    Route::get('/sale/index_data_baki/{id}', 'JualController@index_data_baki')
        ->name('sale.index_data_baki');

    Route::get('/sale/action', 'JualController@action')
        ->name('sale.action');

    Route::post('/sale/insert', 'JualController@insert')
        ->name('sale.insert');

    Route::get('/products_all/update', 'ProductController@update_new')
        ->name('products_all.update');

    Route::get('/products_all/edit', 'ProductController@edit')
        ->name('products_all.edit');

    Route::get('/products_notas', 'ProductController@list')
        ->name('products.list');
    
    Route::get('/products_emas', 'ProductController@list_emas')
        ->name('products.emas');

    Route::get('/products_all', 'ProductController@list_all')
        ->name('products.all');

    Route::get('/products_nota', 'ProductController@list_nota')
        ->name('products.nota');

    Route::get('/products_luar', 'ProductController@list_luar')
        ->name('products.luar');

    Route::get('/products_dataluar', 'ProductController@dataluar')
        ->name('products.dataluar');

    Route::delete('/products/delete/{id}', 'ProductController@delete_product')
        ->name('products.delete');

    Route::get('/products_datanota', 'ProductController@datanota')
        ->name('products.datanota');

    Route::post('/products_insert_luar', 'ProductController@insert_luar')
        ->name('products.insert_luar');

    Route::post('/products_insert_nota', 'ProductController@insert_nota')
        ->name('products.insert_nota');

    Route::get('/products_pending', 'ProductController@list_pending')
        ->name('products.pending');

    Route::post('/products_updatepending', 'ProductController@update_pending')
        ->name('products.updatepending');

    Route::post('/products_updateall', 'ProductController@update_all')
        ->name('products.updateall');

    Route::post('/products_updatestatus', 'ProductController@update_status')
        ->name('products.updatestatus');

    Route::get('/products_datapending', 'ProductController@data_pending')
        ->name('products.datapending');

    Route::post('/products_insert', 'ProductController@insert')
        ->name('products.insert');

    Route::get('/products_data/{id}', 'ProductController@index_datas')
        ->name('products.data');

    Route::post('/products_all_data', 'ProductController@data_all')
        ->name('products.all_data');

    Route::get('/products_index_data/{id}', 'ProductController@index_datas')
        ->name('products.index_data');

    Route::get('/products/baki', 'ProductController@index_baki')
        ->name('products.baki');

    Route::get('/products_reparasi', 'ProductController@list_reparasi')
        ->name('products.reparasis');

    Route::get('/products_lebur', 'ProductController@list_lebur')
        ->name('products.lebur');

    Route::get('/products_baki/{id}', 'ProductController@list_baki')
        ->name('products.baki');

    Route::get('/products_baki/update/{id}/{product}', 'ProductController@update_baki')
        ->name('products.baki_update');

    // Route::get('/products_baki', 'ProductController@list_baki')
    //     ->name('products.baki');

    Route::get('/products_cuci', 'ProductController@list_cuci')
        ->name('products.cuci');

    Route::get('/products_gudang', 'ProductController@list_gudang')
        ->name('products.gudang');

    Route::get('/discounts', 'KaratController@list_diskon')
        ->name('discounts.list');

    Route::get('/discounts/edit/{id}', 'KaratController@edit_diskon')
        ->name('discounts.edit');

    Route::get('/discounts/index_discounts', 'KaratController@index_diskon')
        ->name('karats.index_diskon');
    
    Route::patch('/discounts/update_diskon/{id}', 'KaratController@update_diskon')
        ->name('karat.update_diskon');

    Route::get('/karats', 'KaratController@list')
        ->name('karats.list');

    Route::post('/karats', 'KaratController@insert')
        ->name('karats.insert');

    Route::delete('/karats/{id}', 'KaratController@delete')
        ->name('karats.delete');

    Route::post('/karats_update', 'KaratController@update')
        ->name('karats.update');

    Route::get('/karats/index_data', 'KaratController@index_data')
        ->name('karats.index_data');

    Route::get('/karats_history', 'KaratController@history')
        ->name('karats.history');

    Route::get('/karats_history_data', 'KaratController@history_data')
        ->name('karats.history_data');

    Route::get('/penerimaan-barangs', 'GoodReceiptController@create')
        ->name('penerimaan.create');

    Route::get('/penerimaan-barangs/qr/{id}', 'GoodReceiptController@qr')
        ->name('penerimaan.qr');

    Route::get('/penerimaan-barangs/qr_data/{id}', 'GoodReceiptController@qr_data')
        ->name('penerimaan.qr_data');

    Route::get('/penerimaan-barangs/detail/{id}', 'GoodReceiptController@detail')
        ->name('penerimaan.detail');

    Route::get('/penerimaan-barangs/product/{id}', 'GoodReceiptController@products')
        ->name('penerimaan.product');
    
    Route::post('/penerimaan-barangs/product', 'GoodReceiptController@product_update')
        ->name('penerimaan.product_update');
    
    Route::post('/penerimaan-barangs', 'GoodReceiptController@insert')
        ->name('penerimaan.insert');

    Route::get('/penerimaan-barangs/tambah', 'GoodReceiptController@tambah')
        ->name('penerimaan.tambah');
});


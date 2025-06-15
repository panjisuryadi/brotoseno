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
    $module_name = 'goodsreceipt';
    $controller_name = 'GoodsReceiptsController';


    // Toko - BuyBack Barang Luar
    Route::get("$module_name/toko/buyback-barangluar", ['as' => "$module_name.toko.buyback-barangluar.index", 'uses' => "Toko\BuyBackBarangLuar\GoodsReceiptsController@index"]);

    Route::get("$module_name/toko/buyback-barangluar/{item}/print/", ['as' => "$module_name.toko.buyback-barangluar.print", 'uses' => "Toko\BuyBackBarangLuar\GoodsReceiptsController@print_item"]);

    Route::get("$module_name/toko/buyback-barangluar/create-nota", ['as' => "$module_name.toko.buyback-barangluar.create-nota", 'uses' => "Toko\BuyBackBarangLuar\GoodsReceiptsController@create_nota"]);

    Route::get("$module_name/toko/buyback-barangluar/nota/{id}", ['as' => "$module_name.toko.buyback-barangluar.nota.show", 'uses' => "Toko\BuyBackBarangLuar\GoodsReceiptsController@show_nota"]);
    Route::get("$module_name/toko/buyback-barangluar/nota/print/{id}", ['as' => "$module_name.toko.buyback-barangluar.nota.print", 'uses' => "Toko\BuyBackBarangLuar\GoodsReceiptsController@print_nota"]);

    Route::get("$module_name/toko/buyback-barangluar/index_data_nota", ['as' => "$module_name.toko.buyback-barangluar.index_data_nota", 'uses' => "Toko\BuyBackBarangLuar\GoodsReceiptsController@index_data_nota"]);

    Route::get("$module_name/toko/buyback-barangluar/index_data_nota_office", ['as' => "$module_name.toko.buyback-barangluar.index_data_nota_office", 'uses' => "Toko\BuyBackBarangLuar\GoodsReceiptsController@index_data_nota_office"]);


    Route::patch("$module_name/toko/buyback-barangluar/nota-process", ['as' => "$module_name.toko.buyback-barangluar.nota-process", 'uses' => "Toko\BuyBackBarangLuar\GoodsReceiptsController@nota_process"]);

    Route::get("$module_name/toko/buyback-barangluar/index_data_item", ['as' => "$module_name.toko.buyback-barangluar.index_data_item", 'uses' => "Toko\BuyBackBarangLuar\GoodsReceiptsController@index_data_item"]);

    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);

      Route::get("$module_name/riwayat-penerimaan", ['as' => "$module_name.riwayat_penerimaan", 'uses' => "$controller_name@riwayat_penerimaan"]);


  Route::get("$module_name/index_data_completed", ['as' => "$module_name.index_data_completed", 'uses' => "$controller_name@index_data_completed"]);



    Route::get("$module_name/add_produk_modal/{id}", ['as' => "$module_name.add_produk_modal", 'uses' => "$controller_name@add_produk_modal"]);


    Route::get("$module_name/cetak/{id}", ['as' => "$module_name.cetak", 'uses' => "$controller_name@cetak"]);


   Route::get("$module_name/print/{id}", ['as' => "$module_name.print", 'uses' => "$controller_name@print"]);


   Route::get("$module_name/view_produk/{id}", ['as' => "$module_name.view_produk", 'uses' => "$controller_name@view_produk"]);

    Route::patch("$module_name/update_status/{id}", ['as' => "$module_name.update_status", 'uses' => "$controller_name@update_status"]);

 Route::get("$module_name/print_produk/{kode_pembelian}", ['as' => "$module_name.print_produk", 'uses' => "$controller_name@print_produk"]);

   Route::get("$module_name/index_data_product/{kode_pembelian}", ['as' => "$module_name.index_data_product", 'uses' => "$controller_name@index_data_product"]);

    Route::get("$module_name/add-products-categories/{id}", ['as' => "$module_name.add_products_by_categories", 'uses' => "$controller_name@add_products_by_categories"]);

    Route::get("$module_name/{id}/edit_status", ['as' => "$module_name.edit_status", 'uses' => "$controller_name@edit_status"]);
    Route::post("$module_name/update_status_pembelian/", ['as' => "$module_name.update_status_pembelian", 'uses' => "$controller_name@update_status_pembelian"]);

  // Debts
  Route::get("$module_name/debts", ['as' => "$module_name.debts", 'uses' => "$controller_name@debts"]);
  Route::get("$module_name/debts-data", ['as' => "$module_name.debts_data", 'uses' => "$controller_name@debts_data"]);


    Route::resource("$module_name", "$controller_name");

});

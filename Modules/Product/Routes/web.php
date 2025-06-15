<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth'], function () {
    //Print Barcode
    Route::get('/products/print-barcode', 'BarcodeController@printBarcode')->name('barcode.print');

    //Product
      Route::post("products/save", ['as' => "products.save", 'uses' => "ProductController@save"]);

      //Product
      Route::post("products/update_status", ['as' => "products.update_status", 'uses' => "ProductController@update_status"]);

  //Product
      Route::post("products/saveajax", ['as' => "products.saveajax", 'uses' => "ProductController@saveAjax"]);

      Route::get("products/index_data", ['as' => "products.index_data", 'uses' => "ProductController@index_data"]);

  Route::get("products/index_distribusi", ['as' => "products.index_distribusi", 'uses' => "ProductController@index_distribusi"]);

    //Print Sertifikat
    Route::get("products/show_sertifikat/{id}", ['as' => "products.show_sertifikat", 'uses' => "ProductController@showSertifikat"]);

    Route::get("products/print-sertifikat/{id}", ['as' => "products.print_sertifikat", 'uses' => "ProductController@printSertifikat"]);

  // Proses
  // Cuci
  Route::get("products/process/cuci", ['as' => "products.process.cuci", 'uses' => "Proses\ProductController@cuci"]);
  Route::get("products/process/get_cuci", ['as' => "products.process.get_cuci", 'uses' => "Proses\ProductController@get_cuci"]);
  Route::get("products/get_stock_cuci", ['as' => "products.get_stock_cuci", 'uses' => "Proses\ProductController@get_stock_cuci"]);

  //rongsok
  Route::get("products/process/rongsok", ['as' => "products.process.rongsok", 'uses' => "Proses\ProductController@rongsok"]);
  Route::get("products/process/get_rongsok", ['as' => "products.process.get_rongsok", 'uses' => "Proses\ProductController@get_rongsok"]);
  Route::get("products/get_stock_rongsok", ['as' => "products.get_stock_rongsok", 'uses' => "Proses\ProductController@get_stock_rongsok"]);

  //masak
  Route::get("products/process/masak", ['as' => "products.process.masak", 'uses' => "Proses\ProductController@masak"]);
  Route::get("products/process/get_masak", ['as' => "products.process.get_masak", 'uses' => "Proses\ProductController@get_masak"]);
  Route::get("products/get_stock_masak", ['as' => "products.get_stock_masak", 'uses' => "Proses\ProductController@get_stock_masak"]);


  Route::get("products/process/reparasi", ['as' => "products.process.reparasi", 'uses' => "Proses\ProductController@reparasi"]);
  Route::get("products/process/get_reparasi", ['as' => "products.process.get_reparasi", 'uses' => "Proses\ProductController@get_reparasi"]);
  Route::get("products/get_stock_reparasi", ['as' => "products.get_stock_reparasi", 'uses' => "Proses\ProductController@get_stock_reparasi"]);


  Route::get("products/process/second", ['as' => "products.process.second", 'uses' => "Proses\ProductController@second"]);
  Route::get("products/process/get_second", ['as' => "products.process.get_second", 'uses' => "Proses\ProductController@get_second"]);
  Route::get("products/get_stock_second", ['as' => "products.get_stock_second", 'uses' => "Proses\ProductController@get_stock_second"]);


      Route::get("products/list-reparasi", ['as' => "products.reparasi", 'uses' => "ProductController@listReparasi"]);

     Route::get("products/list-rfid", ['as' => "products.rfid", 'uses' => "ProductController@listRfid"]);

     Route::get("products/list-sortir", ['as' => "products.sortir", 'uses' => "ProductController@sortir"]);
     Route::get("products/ajax-list-sortir", ['as' => "products.ajax_sortir", 'uses' => "ProductController@index_data_sortir"]);

  Route::get("products/gudang-utama", ['as' => "products.gudang.utama", 'uses' => "ProductController@index_gudang_utama"]);



     Route::get("products/ajax-list-gudang-utama", ['as' => "products.ajax_gudang_utama", 'uses' => "ProductController@index_data_gudang_utama"]);

     Route::get("products/ajax-list-reparasi", ['as' => "products.ajax_reparasi", 'uses' => "ProductController@index_data_reparasi"]);



    Route::get("products/show-sortir/{product}", ['as' => "products.show_sortir", 'uses' => "ProductController@show_sortir"]);

   Route::get("products/show-distribusi/{product}", ['as' => "products.show_distribusi", 'uses' => "ProductController@show_distribusi"]);

  Route::patch("products/distribusi-update-status/{id}", ['as' => "products.update_status_distribusi", 'uses' => "ProductController@update_status_distribusi"]);






   Route::patch("products/sortir_update/{id}", ['as' => "products.sortir_update", 'uses' => "ProductController@sortirUpdate"]);




   Route::get("products/kategori/{slug}", ['as' => "products.view_by_kategori", 'uses' => "ProductController@view_by_kategori"]);


   Route::get("products/qrcode/{id}", ['as' => "products.view_qrcode", 'uses' => "ProductController@view_qrcode"]);

   Route::get("products/print-qrcode/{id}", ['as' => "products.getPdf", 'uses' => "ProductController@getPdf"]);


  Route::get("products/tabel-kategori/{id}", ['as' => "products.index_data_by_kategori", 'uses' => "ProductController@index_data_by_kategori"]);



///data RFID

    Route::patch("products/rfid_update/{id}", ['as' => "products.rfid_update", 'uses' => "ProductController@rfidUpdate"]);



     Route::get("products/ajax-list-rfid", ['as' => "products.ajax_rfid", 'uses' => "ProductController@index_data_rfid"]);

    Route::get("products/show-rfid/{product}", ['as' => "products.show_rfid", 'uses' => "ProductController@show_rfid"]);

//=============================================

      Route::post("products/code-generate", ['as' => "products.code_generate", 'uses' => "ProductController@codeGenerate"]);


      Route::get("products/create-modal", ['as' => "products.create-modal", 'uses' => "ProductController@createModal"]);



  Route::get("products/add_produk_modal_from_pembelian/{id}", ['as' => "products.add_produk_modal_from_pembelian", 'uses' => "ProductController@add_produk_modal_from_pembelian"]);


      Route::get("products/getproduct", ['as' => "products.getsalesProduct", 'uses' => "ProductController@getsalesProduct"]);
      Route::get("products/getone/{id}", ['as' => "products.getone", 'uses' => "ProductController@getone"]);


       Route::get("add-products-categories/{id}",
        ['as' => "products.add_products_categories",
         'uses' => "ProductController@add_products_categories"]);


       Route::get("add-products-modal-categories/{id}",
        ['as' => "products.add_products_modal_categories",
         'uses' => "ProductController@add_products_modal_categories"]);



//halaman add produk tanpa modal




 Route::get("product/add-form-pembelian/{id}",
        ['as' => "products.view_group_kategori_pages",
         'uses' => "ProductController@view_group_kategori_pages"]);


 Route::get("view-group-categories/{id}",
        ['as' => "products.view_group_kategori_pages",
         'uses' => "ProductController@view_group_kategori_pages"]);





 Route::get("add-products-categories/{id}",
        ['as' => "products.add_products_by_categories",
         'uses' => "ProductController@add_products_by_categories"]);


 Route::get("add-products-pembelian/{id}",
        ['as' => "products.add_products_pembelian",
         'uses' => "ProductController@addProdukBuyBack"]);


//get produk by kategori
  Route::get("view-main-categories/{id}",
        ['as' => "products.view_main_kategori_modal",
         'uses' => "ProductController@view_main_kategori_modal"]);


    Route::resource('products', 'ProductController');
    //Product Category
     Route::get("product-categories/index_data", ['as' => "categories.index_data", 'uses' => "CategoriesController@index_data"]);
    Route::resource('product-categories', 'CategoriesController')->except('create', 'show');


     //Product Transfer
     Route::get("product-transfer/index_data", ['as' => "products.transfer.index_data", 'uses' => "ProductTransferController@index_data"]);

     Route::get("product-transfer/detail/{id}", ['as' => "products.transfer.detail", 'uses' => "ProductTransferController@detail"]);

      Route::get("product-transfer/approve/{id}", ['as' => "products.transfer.approve", 'uses' => "ProductTransferController@approveModal"]);

      Route::patch("product-transfer/approve-barang/{id}", ['as' => "products.transfer.approvebarang", 'uses' => "ProductTransferController@ApproveProducts"]);



    Route::get('/products-transfer-type/{type}', 'ProductTransferController@type')->name('products.transfer.type');


      Route::resource('product-transfer', 'ProductTransferController')->except('create', 'show');





});


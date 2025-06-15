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
    $module_name = 'penerimaanbarangluar';
    $controller_name = 'PenerimaanBarangLuarsController';

    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/getsummary", ['as' => "$module_name.getsummary", 'uses' => "$controller_name@getsummary"]);  


     Route::get("$module_name/insentif", ['as' => "$module_name.index_insentif", 'uses' => "$controller_name@index_insentif"]);  

 Route::get("$module_name/index_data_insentif", ['as' => "$module_name.index_data_insentif", 'uses' => "$controller_name@index_data_insentif"]);  

      Route::get("$module_name/tambah_insentif", ['as' => "$module_name.tambah_insentif", 'uses' => "$controller_name@tambah_insentif"]);  

      Route::get("$module_name/insentif/print/{incentive}", ['as' => "$module_name.incentive.print", 'uses' => "$controller_name@print_incentive"]);  
      Route::delete("$module_name/insentif/{incentive}", ['as' => "$module_name.incentive.destroy", 'uses' => "$controller_name@destroy_incentive"]); 

    

    Route::get("$module_name/status/{id}", ['as' => "$module_name.status", 'uses' => "$controller_name@status"]); 

    Route::post("$module_name/update_status", ['as' => "$module_name.update_status", 'uses' => "$controller_name@update_status"]);


    Route::resource("$module_name", "$controller_name");

});



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

use Modules\Adjustment\Http\Controllers\GudangOffice;
use Modules\Adjustment\Http\Controllers\Sales;
use Modules\Adjustment\Http\Controllers\PendingOffice;
use Modules\Adjustment\Http\Controllers\Kroom;
use Modules\Adjustment\Http\Controllers\DP;
use Modules\Adjustment\Http\Controllers\PendingCabang;
use Modules\Adjustment\Http\Controllers\Cabang;


Route::group(['middleware' => 'auth'], function () {
    //Product Adjustment
    Route::get('adjustment/continue','AdjustmentController@continue')->name('adjustment.continue');
    Route::get('adjustment/getdatatable', 'AdjustmentController@getdata')->name('adjustment.datatable');
    Route::post('adjustment/getbyqr', 'AdjustmentController@getbyqr')->name('adjustment.getbyqr');
    Route::get('adjustment/print/{id}', 'AdjustmentController@print')->name('adjustment.print');

    // Gudang Office
    Route::get('adjustments/gudang-office', [GudangOffice\AdjustmentController::class,'index'])->name('adjustment.gudang.office.index');
    Route::get('adjustments/gudang-office/create', [GudangOffice\AdjustmentController::class,'create'])->name('adjustment.gudang.office.create');
    Route::get('adjustments/gudang-office/getdata', [GudangOffice\AdjustmentController::class,'getdata'])->name('adjustment.gudang.office.getdata');

    // Sales
    Route::get('adjustments/sales', [Sales\AdjustmentController::class,'index'])->name('adjustment.sales.index');
    Route::get('adjustments/sales/create', [Sales\AdjustmentController::class,'create'])->name('adjustment.sales.create');
    Route::get('adjustments/sales/getdata', [Sales\AdjustmentController::class,'getdata'])->name('adjustment.sales.getdata');

    // Pending Office
    Route::get('adjustments/pending-office', [PendingOffice\AdjustmentController::class,'index'])->name('adjustment.pending.office.index');
    Route::get('adjustments/pending-office/create', [PendingOffice\AdjustmentController::class,'create'])->name('adjustment.pending.office.create');
    Route::get('adjustments/pending-office/getdata', [PendingOffice\AdjustmentController::class,'getdata'])->name('adjustment.pending.office.getdata');

    // Kroom
    Route::get('adjustments/kroom', [Kroom\AdjustmentController::class,'index'])->name('adjustment.kroom.index');
    Route::get('adjustments/kroom/create', [Kroom\AdjustmentController::class,'create'])->name('adjustment.kroom.create');
    Route::get('adjustments/kroom/getdata', [Kroom\AdjustmentController::class,'getdata'])->name('adjustment.kroom.getdata');

    // DP
    Route::get('adjustments/dp', [DP\AdjustmentController::class,'index'])->name('adjustment.dp.index');
    Route::get('adjustments/dp/create', [DP\AdjustmentController::class,'create'])->name('adjustment.dp.create');
    Route::get('adjustments/dp/getdata', [DP\AdjustmentController::class,'getdata'])->name('adjustment.dp.getdata');

    // Pending Cabang
    Route::get('adjustments/pending-cabang', [PendingCabang\AdjustmentController::class,'index'])->name('adjustment.pending.cabang.index');
    Route::get('adjustments/pending-cabang/create', [PendingCabang\AdjustmentController::class,'create'])->name('adjustment.pending.cabang.create');
    Route::get('adjustments/pending-cabang/getdata', [PendingCabang\AdjustmentController::class,'getdata'])->name('adjustment.pending.cabang.getdata');

    // Cabang
    Route::get('adjustments/cabang', [Cabang\AdjustmentController::class,'index'])->name('adjustment.cabang.index');
    Route::get('adjustments/cabang/create', [Cabang\AdjustmentController::class,'create'])->name('adjustment.cabang.create');
    Route::get('adjustments/cabang/getdata', [Cabang\AdjustmentController::class,'getdata'])->name('adjustment.cabang.getdata');

    Route::resource('adjustments', 'AdjustmentController');
    
    //Stock Transfer
    Route::get('stocktransfer', 'StockTransferController@index')->name('stocktransfer.index');
    Route::get('stocktransfer/create', 'StockTransferController@create')->name('stocktransfer.create');
    Route::get('stocktransfer/show/{id}', 'StockTransferController@show')->name('stocktransfer.show');
    Route::post('stocktransfer/create', 'StockTransferController@store')->name('stocktransfer.store');
    Route::get('stocktransfer/getdata', 'StockTransferController@getdata')->name('stocktransfer.getdata');
    Route::get('stocktransfer/getlocation/{location_id}', 'StockTransferController@getlocation')->name('stocktransfer.getlocation');
    
    //Product Stock
    Route::get('rfid', 'RfidController@index')->name('rfid.index');





    Route::get('stocks', 'StocksController@index')->name('stocks.index');
    Route::get('stocks/getdata', 'StocksController@getdata')->name('stock.datatable');
    Route::get('stocks/getsummary', 'StocksController@getsummary')->name('stock.getsummary');
    Route::get('stocks/getone/{id}', 'StocksController@getone')->name('stock.getone');
    


    //adjustment setting
    Route::get('adjustments-setting', 'AdjustmentController@getsetting')->name('adjustment.getsetting');
    Route::get('adjustments/create/qrcode', 'AdjustmentController@create2')->name('adjustments.create.qrcode');
    Route::get('adjustments-setting2', 'AdjustmentController@getsetting2')->name('adjustment.getsetting2');
    Route::get('adjustments-setsetting', 'AdjustmentController@setsetting')->name('adjustment.setadjustment');

    Route::get('adjustments/settings/stop','AdjustmentSettingController@destroy')->name('adjustment.stop');
});

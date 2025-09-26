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
    //Profit Loss Report
    Route::get('/profit-loss-report', 'ReportsController@profitLossReport')
        ->name('profit-loss-report.index');


    //Payments Report
    Route::get('/payments-report', 'ReportsController@paymentsReport')
        ->name('payments-report.index');

    //Payments Report
    Route::get('/piutang-report', 'ReportsController@piutangsReport')
        ->name('piutang-report.index');
    //Payments Report
    Route::get('/hutang-report', 'ReportsController@hutangReport')
        ->name('hutang-report.index');

    //Sales Report
    Route::get('/sales-report', 'ReportsController@salesReport')
        ->name('sales-report.index');
    //Purchases Report
    Route::get('/purchases-report', 'ReportsController@purchasesReport')
        ->name('purchases-report.index');
    //Sales Return Report
    Route::get('/sales-return-report', 'ReportsController@salesReturnReport')
        ->name('sales-return-report.index');
    //Purchases Return Report
    Route::get('/purchases-return-report', 'ReportsController@purchasesReturnReport')
        ->name('purchases-return-report.index');

    // Stock Report Page
    Route::get('/stock/report', 'ReportsController@stockReport')
        ->name('stock-report.index');

    Route::get('/stock-report/summary', 'ReportsController@getFilteredSummary')
        ->name('stock-report.summary');
    // Stock Report Data
    Route::get('/stock/report/data', 'ReportsController@stockReportData')
        ->name('stock-report-data.index');

    // Sales Unit Report Page
    Route::get('/sales-unit/report', 'ReportsController@salesUnitReport')
        ->name('sales-unit-report.index');
    // Sales Unit Report Data
    Route::get('/sales-unit/report/data', 'ReportsController@salesUnitReportData')
        ->name('sales-unit-report-data.index');

    Route::get('/sales-unit/report/excel', 'ReportsController@salesUnitReportExcel')
        ->name('sales-unit-report-data.excel');

    // Sales Per Customers Page
    Route::get('/sales-customers/report', 'ReportsController@salesCustomersReport')
        ->name('sales-customers-report.index');
    // Sales Per Customers Data
    Route::get('/sales-customers/report/data', 'ReportsController@salesCustomersReportData')
        ->name('sales-customers-report-data.index');
    // Sales Per Customers Detail Page
    Route::get('/sales-customers/report/{id}', 'ReportsController@salesCustomersReportDetail')
        ->name('sales-customers-report-detail.index');
    // Sales Per Customers Detail Data
    Route::get('/sales-customers/report/data/{id}', 'ReportsController@salesCustomersReportDetailData')
        ->name('sales-customers-report-detail-data.index');
});

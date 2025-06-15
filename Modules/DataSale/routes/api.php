<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\DataSale\Http\Controllers\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['static.api.token'])->group(function () {
    Route::get('/datasales', [Api\DataSalesController::class, 'index']);
});

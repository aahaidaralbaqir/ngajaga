<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Middleware\AuthApi;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('purchase')->group(function () {
	Route::get('/unit',[PurchaseController::class, 'getUnit'])->name('api.purchase.unit');
	Route::get('/supplier',[PurchaseController::class, 'getSupplier'])->name('api.purchase.supplier');
	Route::get('/product',[PurchaseController::class, 'getProduct'])->name('api.purchase.product');
});
<?php

use App\Constant\Permission;
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
	Route::post('/',[PurchaseController::class, 'createPurchaseOrder'])->name('api.purchase.create')->middleware(['auth.basic', 'rbac:'. Permission::CREATE_ORDER_INVOICE]);
	Route::post('/edit',[PurchaseController::class, 'editPurchaseOrder'])->name('api.purchase.create')->middleware(['auth.basic', 'rbac:'. Permission::UPDATE_ORDER_INVOICE]);
	Route::get('/unit',[PurchaseController::class, 'getUnit'])->name('api.purchase.unit')->middleware(['auth.basic', 'rbac:'. Permission::CREATE_ORDER_INVOICE]);
	Route::get('/supplier',[PurchaseController::class, 'getSupplier'])->name('api.purchase.supplier')->middleware(['auth.basic', 'rbac:'. Permission::CREATE_ORDER_INVOICE]);
	Route::get('/product',[PurchaseController::class, 'getProduct'])->name('api.purchase.product')->middleware(['auth.basic', 'rbac:'. Permission::CREATE_ORDER_INVOICE]);
	Route::get('/{purchaseOrderId}',[PurchaseController::class, 'getPurchaseOrderDetail'])->name('api.purchase.product')->middleware(['auth.basic', 'rbac:'. Permission::UPDATE_ORDER_INVOICE]);
});

Route::prefix('transaction')->group(function () {
	Route::get('/account', [TransactionController::class, 'getAccounts'])->name('api.transaction.account')->middleware(['auth.basic', 'rbac:'. Permission::CREATE_TRANSACTION]);;
	Route::post('/edit', [TransactionController::class, 'editTransaction'])->name('api.transaction.account')->middleware(['auth.basic', 'rbac:'. Permission::CREATE_TRANSACTION]);;
	Route::get('/customer', [TransactionController::class, 'getCustomers'])->name('api.transaction.customers')->middleware(['auth.basic', 'rbac:'. Permission::CREATE_TRANSACTION]);;
	Route::get('/{transactionId}', [TransactionController::class, 'getTransactionDetail'])->name('api.transaction.detail')->middleware(['auth.basic', 'rbac:'. Permission::VIEW_TRANSACTION]);;
});
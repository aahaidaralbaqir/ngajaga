<?php

use App\Constant\Permission;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;

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


Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');


Route::prefix('account')->group(function () {
	Route::get('/', [AccountController::class, 'index'])->name('account.index')->middleware(['auth', 'rbac:' . Permission::VIEW_CASH_ACCOUNT]);
	Route::get('/create', [AccountController::class, 'createForm'])->name('account.create.form')->middleware(['auth', 'rbac:' . Permission::CREATE_CASH_ACCOUNT]);
	Route::post('/create', [AccountController::class, 'create'])->name('account.create')->middleware(['auth', 'rbac:' . Permission::CREATE_CASH_ACCOUNT]);
	Route::get('/{accountId}/edit', [AccountController::class, 'editForm'])->name('account.edit.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_CASH_ACCOUNT]);
	Route::post('/edit', [AccountController::class, 'edit'])->name('account.edit')->middleware(['auth', 'rbac:' . Permission::UPDATE_CASH_ACCOUNT]);
});


Route::prefix('product')->group(function () {
	Route::get('/', [ProductController::class, 'index'])->name('product.index')->middleware(['auth', 'rbac:' . Permission::VIEW_PRODUCT]);
	Route::get('/create', [ProductController::class, 'createProductForm'])->name('product.create.form')->middleware(['auth', 'rbac:' . Permission::CREATE_PRODUCT]);
	Route::post('/create', [ProductController::class, 'createProduct'])->name('product.create')->middleware('auth', 'rbac:' . Permission::CREATE_PRODUCT);
	Route::post('/edit', [ProductController::class, 'editProduct'])->name('product.edit')->middleware(['auth', 'rbac:' . Permission::UPDATE_PRODUCT]);
	Route::get('/{productId}/edit', [ProductController::class, 'editProductForm'])->name('product.edit.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_PRODUCT]);
	Route::get('/{productId}/price', [ProductController::class, 'editPriceForm'])->name('product.price.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_PRODUCT]);
	Route::post('/price', [ProductController::class, 'editPrice'])->name('product.price')->middleware(['auth', 'rbac:' . Permission::CONFIGURE_PRICE]);
});

Route::prefix('supplier')->group(function () {
	Route::get('/', [SupplierController::class, 'index'])->name('supplier.index')->middleware(['auth', 'rbac:' . Permission::VIEW_SUPPLIER]);
	Route::get('/create', [SupplierController::class, 'createForm'])->name('supplier.create.form')->middleware(['auth', 'rbac:' . Permission::CREATE_SUPPLIER]);
	Route::post('/create', [SupplierController::class, 'create'])->name('supplier.create')->middleware(['auth', 'rbac:' . Permission::CREATE_SUPPLIER]);
	Route::get('/{supplierId}/edit', [SupplierController::class, 'editForm'])->name('supplier.edit.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_SUPPLIER]);
	Route::post('/edit', [SupplierController::class, 'edit'])->name('supplier.edit')->middleware(['auth', 'rbac:' . Permission::UPDATE_SUPPLIER]);
});


Route::prefix('purchase')->group(function () {
	Route::get('/', [PurchaseController::class, 'index'])->name('purchase.index')->middleware(['auth', 'rbac:' . Permission::VIEW_ORDER_INVOICE]);
	Route::get('/create', [PurchaseController::class, 'createPurchaseForm'])->name('purchase.create.form')->middleware(['auth', 'rbac:' . Permission::CREATE_ORDER_INVOICE]);
	Route::post('/create', [PurchaseController::class, 'createPurchaseOrder'])->name('purchase.create')->middleware(['auth', 'rbac:' . Permission::CREATE_ORDER_INVOICE]);
	Route::get('/{purchaseOrderId}/edit', [PurchaseController::class, 'editPurchaseForm'])->name('purchase.edit.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_ORDER_INVOICE]);
	Route::get('/{purchaseOrderId}/print', [PurchaseController::class, 'printPurchase'])->name('purchase.print')->middleware(['auth', 'rbac:' . Permission::PRINT_ORDER_INVOICE]);
	Route::post('/edit', [PurchaseController::class, 'editPurchaseOrder'])->name('purchase.edit')->middleware(['auth', 'rbac:' . Permission::UPDATE_ORDER_INVOICE]);
	Route::get('/{purchaseOrderId}/cancel', [PurchaseController::class, 'cancelPurchaseOrder'])->name('purchase.cancel')->middleware(['auth', 'rbac:' . Permission::CANCEL_ORDER_INVOICE]);
});

Route::prefix('category')->group(function () {
	Route::get('/', [ProductController::class, 'category'])->name('category.index')->middleware(['auth', 'rbac:' . Permission::VIEW_CATEGORY]);
	Route::get('/create', [ProductController::class, 'createFormCategory'])->name('category.create.form')->middleware(['auth', 'rbac:' . Permission::CREATE_CATEGORY]);
	Route::post('/create', [ProductController::class, 'createCategory'])->name('category.create')->middleware(['auth', 'rbac:' . Permission::CREATE_CATEGORY]);
	Route::get('/{categoryId}/edit', [ProductController::class, 'editFormCategory'])->name('category.edit.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_CATEGORY]);
	Route::post('/edit', [ProductController::class, 'editCategory'])->name('category.edit')->middleware(['auth', 'rbac:' . Permission::UPDATE_CATEGORY]);
});

Route::prefix('shelf')->group(function () {
	Route::get('/', [ProductController::class, 'shelf'])->name('shelf.index')->middleware(['auth', 'rbac:' . Permission::VIEW_SHELF]);
	Route::get('/create', [ProductController::class, 'createFormShelf'])->name('shelf.create.form')->middleware(['auth', 'rbac:' . Permission::CREATE_SHELF]);
	Route::post('/create', [ProductController::class, 'createShelf'])->name('shelf.create')->middleware(['auth', 'rbac:' . Permission::CREATE_SHELF]);
	Route::get('/{shelfId}/edit', [ProductController::class, 'editFormShelf'])->name('shelf.edit.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_SHELF]);
	Route::post('/edit', [ProductController::class, 'editShelf'])->name('shelf.edit')->middleware(['auth', 'rbac:' . Permission::UPDATE_SHELF]);
});


Route::prefix('permission')->group(function () {
	Route::get('/', [PermissionController::class, 'index'])->name('permission.index')->middleware(['auth', 'rbac:' . Permission::VIEW_PERMISSION]);
	Route::get('/create', [PermissionController::class, 'createForm'])->name('permission.create.form')->middleware(['auth', 'rbac:' . Permission::CREATE_PERMISSION]);
	Route::post('/create', [PermissionController::class, 'createPermission'])->name('permission.create')->middleware(['auth', 'rbac:' . Permission::CREATE_PERMISSION]);
	Route::get('/{permissionId}/edit', [PermissionController::class, 'updateForm'])->name('permission.edit.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_PERMISSION]);
	Route::post('/update', [PermissionController::class, 'updatePermission'])->name('permission.update')->middleware(['auth', 'rbac:' . Permission::UPDATE_PERMISSION]);
});

Route::prefix('roles')->group(function () {
	Route::get('/', [RolesController::class, 'index'])->name('roles.index')->middleware(['auth', 'rbac:' . Permission::VIEW_ROLE]);
	Route::get('/create', [RolesController::class, 'createForm'])->name('roles.create.form')->middleware(['auth', 'rbac:' . Permission::CREATE_ROLE]);
	Route::post('/create', [RolesController::class, 'createRole'])->name('roles.create')->middleware(['auth', 'rbac:'. Permission::CREATE_ROLE]);
	Route::get('/update/{rolesId}', [RolesController::class, 'updateForm'])->name('roles.update.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_ROLE]);
	Route::post('/update', [RolesController::class, 'updateRole'])->name('roles.update')->middleware(['auth', 'rbac:' . Permission::UPDATE_ROLE]);
});

Route::prefix('user')->group(function () {
	Route::get('/', [UserController::class, 'index'])->name('user.index')->middleware(['auth', 'rbac:' . Permission::VIEW_USER]);
	Route::get('/create', [UserController::class, 'createForm'])->name('user.create.form')->middleware(['auth', 'rbac:' . Permission::CREATE_USER]);
	Route::post('/create', [UserController::class, 'createUser'])->name('user.create')->middleware(['auth', 'rbac:' . Permission::CREATE_USER]);
	Route::get('/update/{userId}', [UserController::class, 'updateForm'])->name('user.update.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_USER]);
	Route::post('/update', [UserController::class, 'updateUser'])->name('user.update')->middleware(['auth', 'rbac:' . Permission::UPDATE_USER]);
});

Route::prefix('invoice')->group(function () {
	Route::get('/', [InvoiceController::class, 'getInvoices'])->name('invoice.index')->middleware(['auth', 'rbac:' . Permission::VIEW_PURCHASE_INVOICE]);
	Route::get('/create', [InvoiceController::class, 'createInvoiceForm'])->name('invoice.create.form')->middleware(['auth', 'rbac:' . Permission::CREATE_PURCHASE_INVOICE]);
	Route::post('/create', [InvoiceController::class, 'createInvoice'])->name('invoice.create')->middleware(['auth', 'rbac:' . Permission::CREATE_PURCHASE_INVOICE]);
	Route::get('/edit/{invoiceId}', [InvoiceController::class, 'editInvoiceForm'])->name('invoice.edit.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_PURCHASE_INVOICE]);
	Route::post('/edit', [InvoiceController::class, 'editInvoice'])->name('invoice.edit')->middleware(['auth', 'rbac:' . Permission::UPDATE_PURCHASE_INVOICE]);
});

Route::prefix('transaction')->group(function () {
	Route::get('/download', [TransactionController::class, 'downloadReport'])->name('transaction.download')->middleware(['auth', 'rbac:' . Permission::DOWNLOAD_TRANSACTION_REPORT]);
	Route::get('/', [TransactionController::class, 'getTransactions'])->name('transaction.index')->middleware(['auth', 'rbac:' . Permission::VIEW_TRANSACTION]);
	Route::get('/create', [TransactionController::class, 'createTransactionForm'])->name('transaction.create.form')->middleware(['auth' , 'rbac:' . Permission::CREATE_TRANSACTION]);
	Route::post('/create', [TransactionController::class, 'createTransaction'])->name('transaction.create')->middleware(['auth', 'rbac:' . Permission::CREATE_TRANSACTION]);
	Route::get('/customer', [TransactionController::class, 'customer'])->name('transaction.customer')->middleware(['auth', 'rbac:' . Permission::CREATE_TRANSACTION]);
	Route::post('/cart/add', [TransactionController::class, 'addProductToCart'])->name('transaction.cart.add')->middleware(['auth', 'rbac:' . Permission::CREATE_TRANSACTION]);
	Route::post('/cart/remove', [TransactionController::class, 'removeProductFromCart'])->name('transaction.cart.remove')->middleware(['auth', 'rbac:' . Permission::CREATE_TRANSACTION]);
	Route::post('/cart/account', [TransactionController::class, 'chooseAccount'])->name('transaction.account')->middleware(['auth', 'rbac:' . Permission::CREATE_TRANSACTION]);
	Route::post('/cart/action/{actionType}', [TransactionController::class, 'cartAction'])->name('transaction.cart.action')->middleware(['auth', 'rbac:' . Permission::CREATE_TRANSACTION]);
	Route::get('/edit/{transactionId}', [TransactionController::class, 'editTransactionForm'])->name('transaction.edit.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_TRANSACTION]);
	
});

Route::prefix('debt')->middleware('auth')->group(function () {
	Route::get('/', [DebtController::class, 'getDebts'])->name('debt.index')->middleware(['auth', 'rbac:' . Permission::VIEW_DEBT]);
	Route::get('/create', [DebtController::class, 'createDebtForm'])->name('debt.create.form')->middleware(['auth', 'rbac:' . Permission::CREATE_DEBT]);
	Route::post('/', [DebtController::class, 'createDebt'])->name('create.debt')->middleware(['auth', 'rbac:' . Permission::CREATE_DEBT]);
	Route::get('/edit/{debtId}', [DebtController::class, 'editDebtForm'])->name('edit.debt.form')->middleware(['auth', 'rbac:' . Permission::UPDATE_DEBT]);
	Route::post('/edit', [DebtController::class, 'editDebt'])->name('edit.debt')->middleware(['auth', 'rbac:' . Permission::UPDATE_DEBT]);
});

Route::prefix('receivable')->middleware('auth')->group(function () {
	Route::get('/{debtId}', [DebtController::class, 'getReceivable'])->name('receivable.index')->middleware(['rbac:' . Permission::VIEW_RECEIVABLE]);
	Route::get('/{debtId}/create', [DebtController::class, 'createReceivableForm'])->name('receivable.create.form')->middleware(['rbac:' . Permission::CREATE_RECEIVABLE]);
	Route::post('/create', [DebtController::class, 'createReceivable'])->name('receivable.create')->middleware(['rbac:' . Permission::CREATE_RECEIVABLE]);
	Route::get('/edit/{receivableId}', [DebtController::class, 'editReceivableForm'])->name('receivable.edit.form')->middleware(['rbac:' . Permission::UPDATE_RECEIVABLE]);
	Route::post('/edit', [DebtController::class, 'editReceiveable'])->name('receivable.edit')->middleware(['rbac:' . Permission::UPDATE_RECEIVABLE]);
});

Route::prefix('customer')->middleware('auth')->group(function () {
	Route::get('/', [CustomerController::class, 'index'])->name('customer.index')->middleware(['rbac:' . Permission::VIEW_CUSTOMER]);
	Route::get('/create', [CustomerController::class, 'createCustomerForm'])->name('customer.create.form')->middleware(['rbac:' . Permission::CREATE_CUSTOMER]);
	Route::post('/create', [CustomerController::class, 'createCustomer'])->name('customer.create')->middleware(['rbac:' . Permission::CREATE_CUSTOMER]);
	Route::get('/edit/{customerId}', [CustomerController::class, 'editCustomerForm'])->name('customer.edit.form')->middleware(['rbac:' . Permission::UPDATE_CUSTOMER]);
	Route::post('/edit', [CustomerController::class, 'editCustomer'])->name('customer.edit')->middleware(['rbac:' . Permission::UPDATE_CUSTOMER]);
});

Route::prefix('report')->middleware('auth')->group(function () {
	Route::get('/account', [ReportController::class, 'getAccountReport'])->name('account.report')->middleware(['rbac:' . Permission::VIEW_ACCOUNT_REPORT]);;
	Route::get('/product', [ReportController::class, 'getProductReport'])->name('product.report')->middleware(['rbac:' . Permission::VIEW_STOCK_PRODUCT]);;
	Route::get('/product/{productId}', [ReportController::class, 'getProductActivity'])->name('product.activity.report')->middleware(['rbac:' . Permission::VIEW_STOCK_PRODUCT_ACTIVITY]);;
	Route::get('/account/{accountId}', [ReportController::class, 'getAccountActivity'])->name('account.activity.report')->middleware(['rbac:' . Permission::VIEW_ACCOUNT_ACTIVITY]);;
	Route::get('/product/download', [ReportController::class, 'downloadProductReport'])->name('product.report.download')->middleware(['rbac:' . Permission::DOWNLOAD_STOCK_PRODUCT]);
	Route::get('/account/download', [ReportController::class, 'downloadAccountReport'])->name('account.report.download')->middleware(['rbac:' . Permission::DOWNLOAD_ACCOUNT_REPORT]);;
	Route::get('/product/download/{productId}', [ReportController::class, 'downloadProductActivity'])->name('product.activity.download')->middleware(['rbac:' . Permission::DOWNLOAD_STOCK_PRODUCT_ACTIVITY]);
	Route::get('/account/download/{accountId}', [ReportController::class, 'downloadAccountActivity'])->name('account.activity.download')->middleware(['rbac:' . Permission::DOWNLOAD_ACCOUNT_ACTIVITY]);
});


Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/unauthorized', function () {
	return view('admin.unauthorized');
})->name('unauthorized');

Route::get('/profile', [UserController::class, 'getProfile'])->name('profile')->middleware('auth');
Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

Route::get('/login', function () {
	return view('login');
})->name('login')->middleware('guest');
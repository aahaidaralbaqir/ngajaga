<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeroesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionTypeController;

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


Route::prefix('admin')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
	Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

	Route::prefix('report')->group(function () {
		Route::get('/', [TransactionController::class, 'getReport'])->name('report.index')->middleware('auth');
	});
	Route::prefix('account')->group(function () {
		Route::prefix('permission')->group(function () {
			Route::get('/', [PermissionController::class, 'index'])->name('permission.index')->middleware('auth');
			Route::get('/create', [PermissionController::class, 'createForm'])->name('permission.create.form')->middleware('auth');
			Route::post('/create', [PermissionController::class, 'createPermission'])->name('permission.create')->middleware('auth');
			Route::get('/update/{permissionId}', [PermissionController::class, 'updateForm'])->name('permission.update.form')->middleware('auth');
			Route::get('/delete/{permissionId}', [PermissionController::class, 'deletePermission'])->name('permission.delete')->middleware('auth');
			Route::post('/update', [PermissionController::class, 'updatePermission'])->name('permission.update')->middleware('auth');
		});

		Route::prefix('roles')->group(function () {
			Route::get('/', [RolesController::class, 'index'])->name('roles.index')->middleware('auth');
			Route::get('/create', [RolesController::class, 'createForm'])->name('roles.create.form')->middleware('auth');
			Route::post('/create', [RolesController::class, 'createRole'])->name('roles.create')->middleware('auth');
			Route::get('/update/{rolesId}', [RolesController::class, 'updateForm'])->name('roles.update.form')->middleware('auth');
			Route::post('/update', [RolesController::class, 'updateRole'])->name('roles.update')->middleware('auth');
		});

		Route::prefix('user')->group(function () {
			Route::get('/', [UserController::class, 'index'])->name('user.index')->middleware('auth');
			Route::get('/create', [UserController::class, 'createForm'])->name('user.create.form')->middleware('auth');
			Route::post('/create', [UserController::class, 'createUser'])->name('user.create')->middleware('auth');
			Route::get('/update/{userId}', [UserController::class, 'updateForm'])->name('user.update.form')->middleware('auth');
			Route::get('/delete/{userId}', [UserController::class, 'deleteUser'])->name('user.delete')->middleware('auth');
			Route::post('/update', [UserController::class, 'updateUser'])->name('user.update')->middleware('auth');
		});

		
	});
	
	Route::prefix('setting')->group(function () {
		Route::get('/',	[SettingController::class, 'index'])->name('setting.index')->middleware('auth');
		Route::post('/', [SettingController::class, 'updateProfile'])->name('setting.update')->middleware('auth');
		Route::post('/update-avatar', [SettingController::class, 'updateAvatar'])->name('setting.avatar.update')->middleware('auth');
		Route::get('/remove-avatar', [SettingController::class, 'removeAvatar'])->name('setting.avatar.remove')->middleware('auth');
	});

	Route::prefix('heroes')->group(function() {
		Route::get('/', [HeroesController::class, 'index'])->name('heroes.index')->middleware('auth');
		Route::get('/create', [HeroesController::class, 'showCreateForm'])->name('heroes.create.form')->middleware('auth');
		Route::get('/update/{heroesId}', [HeroesController::class, 'showEditForm'])->name('heroes.update.form')->middleware('auth');
		Route::post('/create', [HeroesController::class, 'createHeroes'])->name('heroes.create')->middleware('auth');
		Route::post('/update', [HeroesController::class, 'updateHeroes'])->name('heroes.update')->middleware('auth');
		Route::get('/order/{heroesId}', [HeroesController::class, 'updateOrder'])->name('heroes.order')->middleware('auth');
	});

	Route::prefix('post')->group(function () {
		Route::get('/',  [PostController::class, 'index'])->name('post.index')->middleware('auth');
		Route::get('/create', [PostController::class, 'showCreateForm'])->name('post.create.form')->middleware('auth');
		Route::post('/create', [PostController::class, 'createPost'])->name('post.create')->middleware('auth');
		Route::get('/update/{postId}', [PostController::class, 'showUpdateForm'])->name('post.update.form')->middleware('auth');
		Route::post('/update', [PostController::class, 'updatePost'])->name('post.update')->middleware('auth');
	});

	Route::prefix('structure')->group(function () {
		Route::get('/', [StructureController::class, 'index'])->name('structure.index')->middleware('auth');
		Route::get('/create', [StructureController::class, 'showCreateStructureForm'])->name('structure.create.form')->middleware('auth');
		Route::post('/create', [StructureController::class, 'createStructure'])->name('structure.create')->middleware('auth');
		Route::get('/update/{structureId}', [StructureController::class, 'showEditStructureForm'])->name('structure.update.form')->middleware('auth');
		Route::get('/delete/{structureId}', [StructureController::class, 'deleteStructure'])->name('structure.delete')->middleware('auth');
		Route::post('/update', [StructureController::class, 'updateStructure'])->name('structure.update')->middleware('auth');
	});

	Route::prefix('activity')->group(function () {
		Route::prefix('type')->group(function () {
			Route::get('/', [ActivityController::class, 'getActivityType'])->name('activity.type.index')->middleware('auth');
			Route::get('/create', [ActivityController::class, 'showCreateActivityTypeForm'])->name('activity.type.create.form')->middleware('auth');
			Route::get('/update/{id}', [ActivityController::class, 'showUpdateActivityTypeForm'])->name('activity.type.update.form')->middleware('auth');
			Route::post('/create', [ActivityController::class, 'createActivityType'])->name('activity.type.create')->middleware('auth');
			Route::post('/update', [ActivityController::class, 'updateActivityType'])->name('activity.type.update')->middleware('auth');
		});

		Route::prefix('schedule')->group(function () {
			Route::get('/', [ActivityController::class, 'getSchedule'])->name('activity.schedule.index')->middleware('auth');
		});
	});


	Route::prefix('transaction')->group(function () {
		Route::prefix('type')->group(function () {
			Route::get('/', [TransactionTypeController::class, 'index'])->name('transaction.type.index')->middleware('auth');
			Route::get('/create', [TransactionTypeController::class, 'showCreateTransactionTypeForm'])->name('transaction.type.create.form')->middleware('auth');
			Route::get('/update/{id}', [TransactionTypeController::class, 'showEditTransactionTypeForm'])->name('transaction.type.update.form')->middleware('auth');
			Route::post('/create', [TransactionTypeController::class, 'createTransactionType'])->name('transaction.type.create')->middleware('auth');
			Route::post('/update', [TransactionTypeController::class, 'updateTransactionType'])->name('transaction.type.update')->middleware('auth');
		});
		Route::get('/', [TransactionController::class, 'index'])->name('transaction.index')->middleware('auth'); 
		Route::get('/sample', [TransactionController::class, 'sampleFile'])->name('transaction.sample')->middleware('auth');

		Route::get('/create', [TransactionController::class, 'showCreateTransactionForm'])->name('transaction.create.form')->middleware('auth');
		Route::post('/create', [TransactionController::class, 'createTransaction'])->name('transaction.admin.create')->middleware('auth');
		Route::get('/update/{transactionId}', [TransactionController::class, 'showUpdateTransactionForm'])->name('transaction.update.form')->middleware('auth');
		Route::post('/update', [TransactionController::class, 'updateTransaction'])->name('transaction.admin.update')->middleware('auth');
		
	});

	Route::prefix('distribution')->group(function () {
		Route::get('/', [DistributionController::class, 'index'])->name('distribution.index')->middleware('auth');	
		Route::get('/create', [DistributionController::class, 'showCreateDistributionForm'])->name('distribution.create.form')->middleware('auth');
		Route::post('/create', [DistributionController::class, 'createDistribution'])->name('distribution.create')->middleware('auth');
		Route::get('/update/{transactionId}', [DistributionController::class, 'showUpdateDistributionForm'])->name('distribution.update.form')->middleware('auth');
		Route::post('/update', [DistributionController::class, 'updateDistribution'])->name('distribution.update')->middleware('auth');
	});

	
	Route::get('/', [DashboardController::class, 'index'])->name('admin')->middleware('auth');

	Route::prefix('payment')->group(function () {
		Route::get('/', [PaymentController::class, 'index'])->name('payment.index')->middleware('auth');
		Route::get('/create', [PaymentController::class, 'createForm'])->name('payment.create.form')->middleware('auth');
		Route::post('/create', [PaymentController::class, 'createPayment'])->name('payment.create')->middleware('auth');
		Route::get('/update/{paymentId}', [PaymentController::class, 'updateForm'])->name('payment.update.form')->middleware('auth');
		Route::post('/update', [PaymentController::class, 'updatePayment'])->name('payment.update')->middleware('auth');
	});

	Route::prefix('beneficiary')->group(function () {
		Route::get('/', [BeneficiaryController::class, 'index'])->name('beneficiary.index')->middleware('auth');
		Route::get('/create', [BeneficiaryController::class, 'createForm'])->name('beneficiary.create.form')->middleware('auth');
		Route::post('/create', [BeneficiaryController::class, 'createBeneficiary'])->name('beneficiary.create')->middleware('auth');
		Route::get('/update/{beneficiaryId}', [BeneficiaryController::class, 'updateForm'])->name('beneficiary.update.form')->middleware('auth');
		Route::get('/delete/{beneficiaryId}', [BeneficiaryController::class, 'deleteBeneficiary'])->name('beneficiary.delete')->middleware('auth');
		Route::post('/update', [BeneficiaryController::class, 'updateBeneficiary'])->name('beneficiary.update')->middleware('auth');
	});
});


Route::get('/login', function () {
	return view('login');
})->name('login')->middleware('guest');

Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/pay', [HomeController::class, 'pay'])->name('pay');

Route::prefix('transaction')->group(function () {
    Route::post('/create', [TransactionController::class, 'create'])->name('transaction.create');
    Route::post('/register', [TransactionController::class, 'register'])->name('transaction.register');
});
Route::get('/payment/{transactionId}', [TransactionController::class, 'payment'])->name('transaction.payment');
Route::get('/checkout/{transactionId}', [TransactionController::class, 'checkout'])->name('transaction.checkout');
Route::get('/complete/{transactionId}', [TransactionController::class, 'complete'])->name('transaction.complete');

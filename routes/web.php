<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeroesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActivityController;
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


	Route::prefix('account')->group(function () {
		Route::prefix('permission')->group(function () {
			Route::get('/', [PermissionController::class, 'index'])->name('permission.index')->middleware('auth');
			Route::get('/create', [PermissionController::class, 'createForm'])->name('permission.create.form')->middleware('auth');
			Route::post('/create', [PermissionController::class, 'createPermission'])->name('permission.create')->middleware('auth');
			Route::get('/update/{permissionId}', [PermissionController::class, 'updateForm'])->name('permission.update.form')->middleware('auth');
			Route::get('/delete/{permissionId}', [PermissionController::class, 'deletePermission'])->name('permission.delete')->middleware('auth');
			Route::post('/update', [PermissionController::class, 'updatePermission'])->name('permission.update')->middleware('auth');
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
	});
	Route::get('/', [DashboardController::class, 'index'])->name('admin')->middleware('auth');
});



Route::get('/login', function () {
	return view('login');
})->name('login')->middleware('guest');

Route::get('/', function() {
	return view('home');
});
<?php

use App\Http\Controllers\AccountController;
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
use App\Http\Controllers\ProductController;
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


Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');


Route::prefix('account')->group(function () {
	Route::get('/', [AccountController::class, 'index'])->name('account.index')->middleware('auth');
	Route::get('/create', [AccountController::class, 'createForm'])->name('account.create.form')->middleware('auth');
	Route::post('/create', [AccountController::class, 'create'])->name('account.create')->middleware('auth');
	Route::get('/{accountId}/edit', [AccountController::class, 'editForm'])->name('account.edit.form')->middleware('auth');
	Route::post('/edit', [AccountController::class, 'edit'])->name('account.edit')->middleware('auth');
});


Route::prefix('product')->group(function () {
	Route::get('/', [ProductController::class, 'index'])->name('product.index')->middleware('auth');
});

Route::prefix('category')->group(function () {
	Route::get('/', [ProductController::class, 'category'])->name('category.index')->middleware('auth');
});

Route::prefix('shelf')->group(function () {
	Route::get('/', [ProductController::class, 'shelf'])->name('shelf.index')->middleware('auth');
});


Route::prefix('permission')->group(function () {
	Route::get('/', [PermissionController::class, 'index'])->name('permission.index')->middleware('auth');
	Route::get('/create', [PermissionController::class, 'createForm'])->name('permission.create.form')->middleware('auth');
	Route::post('/create', [PermissionController::class, 'createPermission'])->name('permission.create')->middleware('auth');
	Route::get('/{permissionId}/edit', [PermissionController::class, 'updateForm'])->name('permission.edit.form')->middleware('auth');
	Route::get('/delete/{permissionId}', [PermissionController::class, 'deletePermission'])->name('permission.delete')->middleware('auth');
	Route::post('/update', [PermissionController::class, 'updatePermission'])->name('permission.update')->middleware('auth');
});

Route::prefix('roles')->group(function () {
	Route::get('/', [RolesController::class, 'index'])->name('roles.index')->middleware('auth');
	Route::get('/create', [RolesController::class, 'createForm'])->name('roles.create.form')->middleware('auth');
	Route::post('/create', [RolesController::class, 'createRole'])->name('roles.create')->middleware('auth');
	Route::get('/update/{rolesId}', [RolesController::class, 'updateForm'])->name('roles.update.form')->middleware('auth');
	Route::get('/delete/{rolesId}', [RolesController::class, 'deleteRole'])->name('roles.delete')->middleware('auth');
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

Route::prefix('setting')->group(function () {
	Route::get('/',	[SettingController::class, 'index'])->name('setting.index')->middleware('auth');
	Route::post('/', [SettingController::class, 'updateProfile'])->name('setting.update')->middleware('auth');
	Route::post('/update-avatar', [SettingController::class, 'updateAvatar'])->name('setting.avatar.update')->middleware('auth');
	Route::get('/remove-avatar', [SettingController::class, 'removeAvatar'])->name('setting.avatar.remove')->middleware('auth');
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



Route::get('/', [DashboardController::class, 'index'])->name('admin')->middleware('auth');


Route::get('/login', function () {
	return view('login');
})->name('login')->middleware('guest');
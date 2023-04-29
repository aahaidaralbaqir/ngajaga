<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeroesController;

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
	});
	Route::get('/', [DashboardController::class, 'index'])->name('admin')->middleware('auth');
});



Route::get('/login', function () {
	return view('login');
})->name('login')->middleware('guest');
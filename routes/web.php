<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;

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
	Route::get('/setting', [SettingController::class, 'index'])->name('setting')->middleware('auth');
	Route::post('/setting', [SettingController::class, 'updateProfile'])->middleware('auth');
	Route::get('/', [DashboardController::class, 'index'])->name('admin')->middleware('auth');
});



Route::get('/login', function () {
	return view('login');
})->name('login');
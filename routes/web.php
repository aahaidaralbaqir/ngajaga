<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
	Route::get('/', function () {
		return view('admin.index');
	})->name('admin')->middleware('auth');
});



Route::get('/login', function () {
	return view('login');
})->name('login');
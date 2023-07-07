<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\HomeController;
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

Route::post('/schedule/create', [ActivityController::class, 'createSchedule']);
Route::get('/schedule', [ActivityController::class, 'getScheduleList']);
Route::post('/schedule/update', [ActivityController::class, 'updateSchedule']);
Route::delete('/schedule/{scheduleId}', [ActivityController::class, 'deleteSchedule']);
Route::get('/banner', [HomeController::class, 'getBanner'])->name('banner');
Route::prefix('transaction')->group(function () {
	Route::post('/token', [TransactionController::class, 'paymentToken'])->name('transaction.token');
	Route::post('/notification', [TransactionController::class, 'notification'])->name('transaction.notification');
	Route::post('/type/summary', [TransactionController::class, 'summaryTransactionType'])->name('transaction.type.summary');
});

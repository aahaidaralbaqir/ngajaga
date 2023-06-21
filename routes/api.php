<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TransactionController;
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
Route::delete('/schedule/{scheduleId}', [ActivityController::class, 'deleteSchedule']);

Route::post('/transaction/token', [TransactionController::class, 'paymentToken'])->name('transaction.token');
Route::post('/transaction/notification', [TransactionController::class, 'notification'])->name('transaction.notification');
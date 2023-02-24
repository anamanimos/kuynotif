<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendController;

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
Route::post('/newbooking', [SendController::class, 'newBooking']);
Route::post('/paymentconfirm', [SendController::class, 'paymentConfirm']);
Route::post('/paymentsuccess', [SendController::class, 'paymentSuccess']);
Route::post('/paymentdecline', [SendController::class, 'paymentDecline']);
Route::post('/paymentfailed', [SendController::class, 'paymentFailed']);
Route::post('/paymentrefund', [SendController::class, 'paymentRefund']);
Route::post('/paymentexpired', [SendController::class, 'paymentExpired']);

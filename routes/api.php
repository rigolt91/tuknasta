<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('validateform', [PaymentController::class, 'validateForm']);
Route::get('efstoken', [PaymentController::class, 'getToken']);
Route::post('verify', [PaymentController::class, 'verify']);
Route::post('sale', [PaymentController::class, 'sale']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

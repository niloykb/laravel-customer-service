<?php

use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', AuthController::class);
    Route::apiResource('invoices', InvoiceController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::post('invoices/bulk', [InvoiceController::class, 'bulkStore']);
});

Route::post('users/login', [AuthController::class, 'login']);
Route::post('users/registration', [AuthController::class, 'registration']);

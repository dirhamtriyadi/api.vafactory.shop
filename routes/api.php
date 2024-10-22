<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('orders/get/{order}', [App\Http\Controllers\Api\v1\OrderController::class, 'getByOrder'])->name('orders.getByOrder');
//API route for registering a new user
Route::post('/v1/register', [App\Http\Controllers\Api\v1\AuthController::class, 'register'])->name('register');
//API route for logging user in
Route::post('/v1/login', [App\Http\Controllers\Api\v1\AuthController::class, 'login'])->name('login');

Route::prefix('v1')->group(function () {
    Route::resource('users', App\Http\Controllers\Api\v1\UserController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', function(Request $request) {
        // return profile user with roles and permissions
        return $request->user()->load('roles.permissions');
    });
    Route::prefix('v1')->group(function () {
        // Route::resource('users', App\Http\Controllers\Api\v1\UserController::class);
        Route::resource('payment-methods', App\Http\Controllers\Api\v1\PaymentMethodController::class)->except(['edit']);
        Route::resource('print-types', App\Http\Controllers\Api\v1\PrintTypeController::class)->except(['edit']);
        Route::get('products/new-code', [App\Http\Controllers\Api\v1\ProductController::class, 'getNewProductCode']);
        Route::resource('products', App\Http\Controllers\Api\v1\ProductController::class)->except(['edit']);
        Route::get('cash-flows/get-all', [App\Http\Controllers\Api\v1\CashFlowController::class, 'getAll']);
        Route::resource('cash-flows', App\Http\Controllers\Api\v1\CashFlowController::class)->except(['edit', 'update']);
        Route::resource('customers', App\Http\Controllers\Api\v1\CustomerController::class);
        Route::resource('transactions', App\Http\Controllers\Api\v1\TransactionController::class)->except(['create', 'edit']);

        Route::resource('orders', App\Http\Controllers\Api\v1\OrderController::class);
        Route::resource('order-transactions', App\Http\Controllers\Api\v1\OrderTransactionController::class);
        Route::resource('trackings', App\Http\Controllers\Api\v1\TrackingController::class);
        Route::resource('order-trackings', App\Http\Controllers\Api\v1\OrderTrackingController::class);
        Route::put('order-trackings/update/{id}', [App\Http\Controllers\Api\v1\OrderTrackingController::class, 'updateProccess']);
        // API route for logout user
        Route::post('/logout', [App\Http\Controllers\Api\v1\AuthController::class, 'logout']);
    });
});

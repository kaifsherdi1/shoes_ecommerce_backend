<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\PaymentController;

Route::prefix('v1')->group(function () {
    // Public
    Route::post('register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);
    Route::get('products', [ProductController::class,'index']);
    Route::get('products/{id}', [ProductController::class,'show']);
    Route::get('categories', [CategoryController::class,'index']);
    Route::get('categories/{id}', [CategoryController::class,'show']);

    // Protected
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class,'logout']);

        // Products (admin)
        Route::middleware('admin')->group(function () {
            Route::post('products', [ProductController::class,'store']);
            Route::put('products/{id}', [ProductController::class,'update']);
            Route::delete('products/{id}', [ProductController::class,'destroy']);
            Route::post('upload', [UploadController::class,'upload']);
        });

        // Cart & wishlist
        Route::get('cart', [CartController::class,'index']);
        Route::post('cart/add', [CartController::class,'add']);
        Route::post('cart/remove', [CartController::class,'remove']);

        Route::get('wishlist', [WishlistController::class,'index']);
        Route::post('wishlist/add', [WishlistController::class,'add']);
        Route::post('wishlist/remove', [WishlistController::class,'remove']);

        // Orders
        Route::post('checkout', [OrderController::class,'checkout']);
        Route::get('orders', [OrderController::class,'index']);
        Route::get('orders/{id}', [OrderController::class,'show']);

        // Payment webhook / confirm
        Route::post('payment/verify', [PaymentController::class,'verify']);
    });
});

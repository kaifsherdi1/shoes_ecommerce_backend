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
use App\Http\Controllers\Api\ProfileController;

Route::prefix('v1')->group(function () {

    // =========================
    // PUBLIC ROUTES
    // =========================
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Products
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);

    // Categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);

    // Public Reviews - Listing reviews of a product
    Route::get('products/{product_id}/reviews', [ReviewController::class, 'index']);
    Route::get('reviews/{id}', [ReviewController::class, 'show']);

    // =========================
    // PROTECTED ROUTES (Authenticated)
    // =========================
    Route::middleware('auth:sanctum')->group(function () {

        // Profile
        Route::get('profile', [ProfileController::class, 'me']);
        Route::put('profile', [ProfileController::class, 'update']);

        // Logout
        Route::post('logout', [AuthController::class, 'logout']);

        // Cart
        Route::get('cart', [CartController::class, 'index']);
        Route::post('cart/add', [CartController::class, 'add']);
        Route::post('cart/remove', [CartController::class, 'remove']);

        // Wishlist
        Route::get('wishlist', [WishlistController::class, 'index']);
        Route::post('wishlist/add', [WishlistController::class, 'add']);
        Route::post('wishlist/remove', [WishlistController::class, 'remove']);

        // Orders
        Route::post('checkout', [OrderController::class, 'checkout']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/{id}', [OrderController::class, 'show']);
        Route::post('orders/{id}/cancel', [OrderController::class, 'cancel']);
        Route::post('orders/{id}/return', [OrderController::class, 'requestReturn']);

        // Reviews (Write / Update / Delete)
        Route::post('reviews', [ReviewController::class, 'store']);
        Route::put('reviews/{review}', [ReviewController::class, 'update']);
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);

        // Payment
        Route::post('payment/verify', [PaymentController::class, 'verify']);

        // =========================
        // ADMIN ONLY ROUTES
        // =========================
        Route::middleware('admin')->group(function () {

            // Product Admin CRUD
            Route::post('products', [ProductController::class, 'store']);
            Route::put('products/{id}', [ProductController::class, 'update']);
            Route::delete('products/{id}', [ProductController::class, 'destroy']);

            // Upload images
            Route::post('upload', [UploadController::class, 'upload']);

            // Order Admin Actions
            Route::post('orders/{id}/approve-return', [OrderController::class, 'approveReturn']);
            Route::post('orders/{id}/refund', [OrderController::class, 'processRefund']);
            Route::post('orders/{id}/update-status', [OrderController::class, 'adminUpdateStatus']);
            Route::get('admin/orders', [OrderController::class, 'adminList']);
        });
    });

});

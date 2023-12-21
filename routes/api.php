<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes  middleware
Route::middleware(['jwt.verify'])->group(function () {

    // User
    Route::get('/users', [UserController::class, 'all']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    // Products
    Route::get('/products', [ProductController::class, 'all']);
    Route::get('/products/{id}', [ProductController::class, 'get']);
    Route::post('/products', [ProductController::class, 'add']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'delete']);

    //Orders
    Route::post('/orders', [OrderController::class, 'addOrder']);
    Route::get('/orders/{id}', [OrderController::class, 'getOrder']);
    Route::delete('/orders/{id}', [OrderController::class, 'deleteOrder']);
    Route::patch('/orders/{', [OrderController::class, 'updateOrderStatus']);
    Route::get('/orders', [OrderController::class, 'getAllOrders']);

//Cart
    Route::post('/cart', [CartController::class, 'addToCart']);
    Route::get('/cart', [CartController::class, 'allInCart']);
    Route::delete('/cart', [CartController::class, 'deleteFromCart']);
    Route::get('/cart/user/{userId}', [CartController::class, 'getUserCart']);

});

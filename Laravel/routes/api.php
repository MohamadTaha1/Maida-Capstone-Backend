<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserOrderController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Authentication Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Restaurant Routes
Route::get('/restaurants/search', [RestaurantController::class, 'search']);
Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);
Route::get('/restaurants', [RestaurantController::class, 'index']);
// Protected routes for restaurant owners
Route::middleware(['auth:sanctum', 'isOwner'])->group(function () {
    Route::post('/restaurants', [RestaurantController::class, 'create']);
    Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update']);
    Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy']);
});

// Menu Routes
Route::middleware(['auth:sanctum', 'isOwner'])->group(function () {
    Route::apiResource('/menus', MenuController::class);
});

// Dish Routes
// Assuming that only owners should manage dishes
Route::middleware(['auth:sanctum', 'isOwner'])->group(function () {
    Route::apiResource('dishes', DishController::class);
});

// User Orders Routes
Route::middleware('auth:sanctum')->prefix('users/{userId}/orders')->group(function () {
    Route::apiResource('/', UserOrderController::class)->except(['index', 'store', 'show', 'update', 'destroy']);
    Route::get('/', [UserOrderController::class, 'index']);
    Route::post('/', [UserOrderController::class, 'store']);
    Route::get('/{orderId}', [UserOrderController::class, 'show']);
    Route::put('/{orderId}', [UserOrderController::class, 'update']);
    Route::delete('/{orderId}', [UserOrderController::class, 'destroy']);
});

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/restaurants/search', [RestaurantController::class, 'search']);
Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);
Route::get('/restaurants', [RestaurantController::class, 'index']);

Route::apiResource('dishes', DishController::class);
Route::get('/dishes', [DishController::class, 'index']);
Route::post('/dishes', [DishController::class, 'store']);
Route::get('/dishes/{id}', [DishController::class, 'show']);
Route::put('/dishes/{id}', [DishController::class, 'update']);
Route::delete('/dishes/{id}', [DishController::class, 'destroy']);

Route::apiResource('/menus', MenuController::class);



// Nested User Orders Routes
Route::prefix('users/{userId}/orders')->group(function () {
    Route::get('/', [UserOrderController::class, 'index']);
    Route::post('/', [UserOrderController::class, 'store']);
    Route::get('/{orderId}', [UserOrderController::class, 'show']);
    Route::put('/{orderId}', [UserOrderController::class, 'update']);
    Route::delete('/{orderId}', [UserOrderController::class, 'destroy']);
});





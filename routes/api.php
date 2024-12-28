<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('role:user')->group(function () {
    Route::get('/cars', [CarController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
    Route::patch('/orders/{order}/pay', [OrderController::class, 'markAsPaid']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/addcars', [CarController::class, 'saveCar']);
    Route::patch('/unavailablecars/{id}', [CarController::class, 'markCarAsUnavailable']);

});

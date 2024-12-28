<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CarController;
use App\Http\Controllers\Frontend\OrderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/', [CarController::class, 'index'])->name('cars.index');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create/{car}', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::patch('/orders/{order}/mark-paid', [OrderController::class, 'markAsPaid'])->name('orders.markAsPaid');

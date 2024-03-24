<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

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

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware('jwt.auth')->group(function () {
    Route::prefix('products')->name('products.')->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/deleted', [ProductController::class, 'deleted'])->name('deleted');
        Route::get('/{product}', [ProductController::class, 'edit'])->name('edit');
        Route::get('/restore/{id}', [ProductController::class, 'restore'])->name('restore');
    
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::post('/{product}', [ProductController::class, 'update'])->name('update');
    
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });


    Route::prefix('orders')->name('orders.')->group(function(){
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'edit'])->name('edit');
        
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::post('/{order}', [OrderController::class, 'update'])->name('update');
        
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
    });
    
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
});
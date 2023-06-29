<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\Product::class, 'index']);
Route::post('/checkout',[\App\Http\Controllers\Product::class,'checkout'])->name('checkout');
Route::post('/success',[\App\Http\Controllers\Product::class,'checkout'])->name('checkout.success');
Route::post('/cancel',[\App\Http\Controllers\Product::class,'checkout'])->name('checkout.cancel');

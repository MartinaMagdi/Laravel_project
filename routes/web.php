<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [ProductController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::post('/products/search', [ProductController::class, "search"])->name('products.search');
Route::get('/products/delete/{id}', [ProductController::class, "delete"])->name('products.delete');
Route::resource('orders', OrderController::class);
Route::resource('user', UserController::class );

#############################GoogleLogin
Route::get('auth/google',[GoogleController::class,'googlepage']);
Route::get('auth/google/callback',[GoogleController::class,'googlecallback']);

Route::resource('orders', OrderController::class);

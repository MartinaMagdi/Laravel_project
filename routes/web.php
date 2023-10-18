<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderAdminCheck;
use App\Http\Controllers\AdminOrders;

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
Route::resource('orders', OrderController::class);

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
Route::get('profile/changepassword', [ProfileController::class ,'changepassword'] )->name('changepassword.edit');
Route::post('profile/changepassword/{id}', [ProfileController::class ,'updatepassword'] )->name('changepassword.update');

Route::resource('/user', UserController::class );

Route::get('auth/google',[GoogleController::class,'googlepage']);
Route::get('auth/google/callback',[GoogleController::class,'googlecallback']);
Route::resource('orders', OrderController::class);

// user
// Route::post('orders', [ OrderController::class , 'filterOrder' ] );

// admin

Route::get('check', [OrderAdminCheck::class, 'index']);
Route::get('admin-orders', [AdminOrders::class, 'index'])->name('admin-index');
Route::post('admin-orders', [AdminOrders::class, 'update'])->name('admin-update');

<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::post('/products/search', [ProductController::class, "search"])->name('products.search');
Route::resource('orders', OrderController::class);

// user
// Route::post('orders', [ OrderController::class , 'filterOrder' ] );

// admin

Route::get('check', [OrderAdminCheck::class, 'index']);
Route::get('admin-orders', [AdminOrders::class, 'index'])->name('admin-index');
Route::post('admin-orders', [AdminOrders::class, 'update'])->name('admin-update');

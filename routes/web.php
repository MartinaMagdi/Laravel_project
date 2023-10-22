<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderAdminCheck;
use App\Http\Controllers\AdminOrders;
use App\Http\Controllers\CartController;

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
#############################Facebook
Route::get('auth/facebook',[FacebookController::class,'facebookpage']);
Route::get('auth/facebook/callback',[FacebookController::class,'facebookredirect']);

Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
Route::get('profile/changepassword', [ProfileController::class ,'changepassword'] )->name('changepassword.edit');
Route::post('profile/changepassword/{id}', [ProfileController::class ,'updatepassword'] )->name('changepassword.update');

Route::resource('/user', UserController::class )->middleware('auth');

Route::get('order', [OrderController::class, 'filter'])->name('order.filter');

// admin
Route::get('check', [OrderAdminCheck::class, 'index'])->name('admin-check');
Route::get('admin-orders', [AdminOrders::class, 'index'])->name('admin-index');
Route::post('admin-orders', [AdminOrders::class, 'update'])->name('admin-update');
// Route::get('check', [OrderAdminCheck::class, 'index'])->name('check.index');
Route::get('checks', [OrderController::class, 'filter'])->name('check.filter');
Route::get('checks', [OrderController::class, 'filterWithStatusDone'])->name('check.filterWithStatusDone');

Route::resource('admin', AdminOrders::class);
Route::get('admin-filter', [OrderController::class, 'filter'])->name('admin.filter');


Route::resource('cart', CartController::class);

Route::post('cart/{orders}', [CartController::class, 'submit'])->name('cart.submit');


Route::get('/checkout', [StripeController::class,'checkout'])->name('checkout');
Route::post('/session', [StripeController::class,'session'])->name('session');
Route::get('/success',  [StripeController::class,'success'])->name('success');
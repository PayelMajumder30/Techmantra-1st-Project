<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\{AdminController, ProductController,CategoryController, OrderController,CartController};
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

//
Route::get('/admin/login',[AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'submitLogin'])->name('admin.dashboard');

Route::group(['middleware' => ['auth', IsAdmin::class], 'prefix' => 'admin'], function(){
    Route::get('logout',[AdminController::class, 'logout'])->name('admin.logout');
    Route::get('dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('products/list',[ProductController::class, 'productList'])->name('products.list')->withoutMiddleware([IsAdmin::class]);
    Route::get('products/add',[ProductController::class, 'addProduct'])->name('products.add');
    Route::post('products/add',[ProductController::class, 'storeProduct'])->name('products.store');
    Route::get('products/edit/{id}',[ProductController::class, 'editProduct'])->name('products.edit');
    Route::post('products/edit/{id}',[ProductController::class, 'updateProduct'])->name('products.update');
    Route::delete('products/delete/{id}',[ProductController::class, 'destroyProduct'])->name('products.delete');
    Route::get('/products/list', [ProductController::class, 'index'])->name('products.list');
    Route::get('/categories/add', [CategoryController::class, 'addCategory'])->name('categories.add');
    Route::post('/categories/add', [CategoryController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/list', [CategoryController::class, 'categoryList'])->name('categories.list');
    Route::get('categories/edit/{id}',[CategoryController::class, 'editCategory'])->name('categories.edit');
    Route::post('categories/edit/{id}',[CategoryController::class, 'updateCategory'])->name('categories.update');
    Route::delete('categories/delete/{id}',[CategoryController::class, 'destroyCategory'])->name('categories.delete');
    Route::get('orders/add', [OrderController::class, 'addOrder'])->name('orders.add');
    Route::post('orders/add', [OrderController::class, 'storeOrder'])->name('orders.store');
    Route::get('orders/list', [OrderController::class, 'listOrder'])->name('orders.list');
    Route::get('orders/price', [OrderController::class, 'priceOrder'])->name('price');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [cartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/place-order', [CartController::class, 'placeOrder'])->name('cart.placeOrder');
    Route::get('/cart/show', [CartController::class, 'showOrder'])->name('cart.showOrder');
    Route::delete('/cart/remove/{id}', [CartController::class, 'deleteCartItem'])->name('cart.delete');
});

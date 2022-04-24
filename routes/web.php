<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth'], 'namespace' => 'Admin'], function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    //=========Product Routes===========//
    Route::get('add/product', [ProductController::class, 'addProduct'])->name('add-product');
    Route::post('product/store', [ProductController::class, 'store'])->name('store-product');
    Route::get('subcategory/ajax/{cat_id}', [CategoryController::class, 'getSubCat']);

    Route::get('manage/product', [ProductController::class, 'manageProduct'])->name('manage-product');
    Route::get('/product-edit/{product_id}', [ProductController::class, 'edit']);
    Route::post('product/data/update', [ProductController::class, 'productDataUpdate'])
        ->name('update-product-data');
    Route::post('product/thumbnail/update', [ProductController::class, 'thumbnailUpdate'])
        ->name('update-product-thumbnail');
    Route::get('/product-delete/{product_id}', [ProductController::class, 'delete']);
});


Route::group(['prefix' => 'user', 'middleware' => ['user', 'auth'], 'namespace' => 'User'], function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('user.dashboard');
});
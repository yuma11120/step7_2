<?php

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




Auth::routes();

Route::get('/', [App\Http\Controllers\ProductController::class, 'welcome']);


Route::get('/show/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('Product.show');

Route::get('/newCreate', [App\Http\Controllers\ProductController::class, 'newCreate'])->name('Product.newCreate');

//入力フォームでルーティングする際は、ルーティングはPOSTで、フォームには@csrf と入力する必要あり
Route::post('/Confirm', [App\Http\Controllers\ProductController::class, 'Confirm'])->name('Product.Confirm');
Route::get('/delete/{id}', [App\Http\Controllers\ProductController::class, 'delete'])->name('Product.delete');
Route::get('/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('Product.edit');
Route::post('/destroy{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('Product.destroy');
Route::post('/login', [App\Http\Controllers\HomeController::class, 'login'])->name('Product.login');
Route::get('/Product.welcome', [App\Http\Controllers\ProductController::class, 'welcome'])->name('Product.index')->middleware('auth');
Route::get('update/Product.welcome', [App\Http\Controllers\ProductController::class, 'welcome'])->name('Product.index')->middleware('auth');
Route::put('/Product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('Product.update');
Route::post('/products/store', [App\Http\Controllers\ProductController::class, 'store'])->name('Product.new')->middleware('auth');





Auth::routes();

Route::get('/home',[App\Http\Controllers\ProductController::class, 'welcome'])->name('Product.index')->middleware('auth');
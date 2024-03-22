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

Route::get('/', [App\Http\Controllers\step7Controller::class, 'welcome']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/show/{id}', [App\Http\Controllers\step7Controller::class, 'show'])->name('step7.show');

Route::get('/newCreate', [App\Http\Controllers\step7Controller::class, 'newCreate'])->name('step7.newCreate');

//入力フォームでルーティングする際は、ルーティングはPOSTで、フォームには@csrf と入力する必要あり
Route::post('/Confirm', [App\Http\Controllers\step7Controller::class, 'Confirm'])->name('step7.Confirm');
Route::get('/delete/{id}', [App\Http\Controllers\step7Controller::class, 'delete'])->name('step7.delete');
Route::get('/edit/{id}', [App\Http\Controllers\step7Controller::class, 'edit'])->name('step7.edit');
Route::post('/update/{id}', [App\Http\Controllers\step7Controller::class, 'update'])->name('step7.update');
Route::post('/destroy{id}', [App\Http\Controllers\step7Controller::class, 'destroy'])->name('step7.destroy');
Route::post('/login', [App\Http\Controllers\step7Controller::class, 'login'])->name('step7.login');
Route::get('/step7.welcome', [App\Http\Controllers\step7Controller::class, 'welcome'])->name('step7.welcome')->middleware('auth');
Route::get('update/step7.welcome', [App\Http\Controllers\step7Controller::class, 'welcome'])->name('step7.welcome')->middleware('auth');

Route::post('/step7.new', [App\Http\Controllers\step7Controller::class, 'store'])->name('step7.new')->middleware('auth');




Auth::routes();

Route::get('/home', [App\Http\Controllers\step7Controller::class, 'welcome'])->name('step7.welcome')->middleware('auth');

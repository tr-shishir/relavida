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



// Route::get('shop', '\App\Http\Controllers\Controller@shop');
Route::any('product/store','App\Http\Controllers\ProductController@store')->name('product.store');
Route::any('product/update/{id}','App\Http\Controllers\ProductController@update')->name('product.update');

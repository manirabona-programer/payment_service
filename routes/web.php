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

Route::get('/', function () {
    return view('auth.login');
});

require __DIR__.'/auth.php';

Route::group(['middleware' => 'is_super_admin'], function () {
    Route::get('/dashcube',  function () { return view('dashcube'); })->name('dashcube');
});

Route::group(['middleware' => 'is_admin'], function () {
    Route::get('/dashboard',  function () { return view('dashboard'); })->name('dashboard');
    Route::resource('/config', 'App\Http\Controllers\ConfigController');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/products', 'App\Http\Controllers\ProductController');
});
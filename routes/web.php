<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;

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

/** SUPER ADMIN ONLY CAN ACCESS THIS ROUTES */
Route::group(['middleware' => 'is_super_admin'], function () {
    Route::get('/dashcube',  function () { return view('dashcube'); })->name('dashcube');
    Route::resource('/users', 'App\Http\Controllers\ConfigController');
});

/** ADMIN ONLY CAN ACCESS THIS ROUTES */
Route::group(['middleware' => 'is_admin'], function () {
    Route::get('/dashboard',  function () { return view('dashboard'); })->name('dashboard');
    Route::resource('/config', 'App\Http\Controllers\ConfigController');
});

/** AUTH USER CAN ACCESS THIS ROUTE INCLUDE ADMIN AND SUPER ADMIN */
Route::group(['middleware' => 'auth'], function () {
    Route::resource('/products', 'App\Http\Controllers\ProductController');
    Route::get('/products/{product}/pay', [PaymentController::class,'processPayment']);
});


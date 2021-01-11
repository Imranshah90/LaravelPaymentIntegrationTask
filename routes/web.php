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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/payment', [App\Http\Controllers\PaymentController::class, 'initPayment'])->name('init-payment');
Route::get('/payment/make-payment/{payment}', [App\Http\Controllers\PaymentController::class, 'makePayment'])->name('make-payment');

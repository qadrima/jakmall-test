<?php

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

Route::middleware(['auth'])->group(function () {
	Route::get('/', 'HomeController@index')->name('home');

	Route::get('/topup-balance', 'TopupController@index')->name('topup_balance');
	Route::post('/topup-balance', 'TopupController@create')->name('topup_balance_create');

	Route::get('/product', 'ProductController@index')->name('product');

	Route::get('/pay-now/{order_no}', 'OrderController@index')->name('pay_now');
	Route::post('/pay-now', 'OrderController@payNow')->name('pay_now_submit');
});

<?php

// default jakarta :)
date_default_timezone_set('Asia/Jakarta');

Auth::routes();

Route::middleware(['auth'])->group(function () {
	
	Route::get('/', 'HomeController@index')->name('home');

	Route::post('/search', 'HomeController@search')->name('search');
	Route::get('/search/{search}', 'HomeController@searchResult')->name('search_result');

	Route::get('/topup-balance', 'TopupController@index')->name('topup_balance');
	Route::post('/topup-balance', 'TopupController@create')->name('topup_balance_create');

	Route::get('/product', 'ProductController@index')->name('product');
	Route::post('/product', 'ProductController@create')->name('product_create');

	Route::get('/pay-now/{order_no}', 'OrderController@index')->name('pay_now');
	Route::post('/pay-now', 'OrderController@payNow')->name('pay_now_submit');
});

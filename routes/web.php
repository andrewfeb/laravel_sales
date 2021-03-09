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
Auth::routes([
    'register' => false,
    'verify' => false,
    'reset' => false,
    'confirm' => false
]);
//level admin
Route::middleware(['auth', 'checkuser:admin'])->group(function () {
    Route::resources([
        'user' => UserController::class
    ]);
});
//level all user
Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('order', 'OrderController@index')->name('order.index');
    Route::get('order/customer', 'OrderController@getCustomer')->name('order.getCustomer');
    Route::get('order/product', 'OrderController@getProduct')->name('order.getProduct');
    Route::post('order', 'OrderController@store')->name('order.store');

    Route::resources([
        'category' => CategoryController::class,
        'product' => ProductController::class,
        'customer' => CustomerController::class
    ]);
});

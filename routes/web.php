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
    return view('welcome');
});
Route::group(['namespace'=>'Front', 'prefix'=>LaravelLocalization::setLocale() , 'middleware' => ['verified','localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],function(){

    Route::get('/index', 'IndexController@index');
    Route::post('/user-cart','IndexController@addCart')->name('add.to.cart');
    Route::get('/cart', 'IndexController@getCart')->name('get.cart');
    Route::post('/cart-clear', 'IndexController@cartClear')->name('cart.clear');

    Route::get('/cart-edit/{product_id}','IndexController@cartProductEdit')->name('cart.product.edit');
    Route::post('/cart-update/{product_id}','IndexController@cartProductUpdate')->name('cart.product.update');

    Route::delete('/cart-delete','IndexController@cartProductDelete')->name('cart.product.delete');
});








Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');


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
    Route::get('shop','IndexController@shop')->name('shop');
    Route::get('/index', 'IndexController@index')->name('index.page');
    Route::post('/user-cart','IndexController@addCart')->name('add.to.cart');
    Route::get('/cart', 'IndexController@getCart')->name('get.cart');
    Route::post('/cart-clear', 'IndexController@cartClear')->name('cart.clear');

    Route::get('/cart-edit/{product_id}','IndexController@cartProductEdit')->name('cart.product.edit');
    Route::post('/cart-update/{product_id}','IndexController@cartProductUpdate')->name('cart.product.update');
    //delete product from cart
    Route::delete('/cart-delete','IndexController@cartProductDelete')->name('cart.product.delete');
    //proceed cart
    Route::get('cart-total','IndexController@cartTotal')->name('get.cart.total');
});
Route::group(['namespace'=>'Order','prefix'=>LaravelLocalization::setLocale() , 'middleware' => ['verified','localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],function(){
    Route::post('place-order','OrderController@placeOrder')->name('place.order');
});

Route::group(['namespace'=>'staticPage', 'prefix'=>LaravelLocalization::setLocale() , 'middleware' => ['verified','localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){
    Route::get('/contactUs','ContactUsMessageController@message')->name('contact-us.message');
    Route::post('/insert-contactUs-message','ContactUsMessageController@insertMessage')->name('insert.contact-us.message');
});








Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');


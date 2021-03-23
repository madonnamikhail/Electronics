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
Route::group(['prefix'=>LaravelLocalization::setLocale() , 'middleware' => ['verified','localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],function(){

    ###################### front
    Route::group(['namespace'=>'Front'], function(){
        //search box
        Route::post('/search-box','IndexController@searchBox')->name('search.box');

        Route::get('/index', 'IndexController@index')->name('index.page');
        Route::post('/user-cart','IndexController@addCart')->name('add.to.cart');
        Route::get('/cart', 'IndexController@getCart')->name('get.cart');
        Route::post('/cart-clear', 'IndexController@cartClear')->name('cart.clear');
        Route::get('/hot_deals/{id}', 'IndexController@hotDeals')->name('hot.deals');



        Route::get('/cart-edit/{product_id}','IndexController@cartProductEdit')->name('cart.product.edit');
        Route::post('/cart-update/{product_id}','IndexController@cartProductUpdate')->name('cart.product.update');
        //delete product from cart
        Route::delete('/cart-delete','IndexController@cartProductDelete')->name('cart.product.delete');
        //proceed cart
        Route::post('cart-total','IndexController@cartTotal')->name('get.cart.total');

        ########################## Profile
        Route::group(['namespace'=>'profile' , 'middleware'=>'auth'], function(){
            Route::get('/profile', 'ProfileController@getProfile')->name('get.profile');
            Route::get('/rating','ProfileController@getRating')->name('get.rating');
            Route::post('/rating/product','ProfileController@ProductRating')->name('product.rating');
            Route::post('/rating/product/insert','ProfileController@ProductRatingInsert')->name('insert');
            // Route::post('/rating/product/insert','ProfileController@ProductRatingInsert')->name('insert');


            ####### changing user data
            Route::post('/profile/changing-info', 'ProfileController@profileChangeInfo')->name('profile.change.info');
            Route::post('/profile/changing-email', 'ProfileController@profileChangeEmail')->name('profile.change.email');
            Route::post('/profile/changing-password', 'ProfileController@profileChangePassword')->name('profile.change.password');

            Route::get('/profile/editing-address/{id}','ProfileController@profileEditAddress')->name('profile.edit.address');
            Route::post('/profile/changing-address/{id}', 'ProfileController@profileChangeAddress')->name('profile.change.address');
            Route::delete('/profile/deleting-address','ProfileController@profileDeleteAddress')->name('profile.delete.address');

            Route::get('/profile/creating-address','ProfileController@profileCreateAddress')->name('profile.create.address');
            Route::post('/profile/storing-address','ProfileController@profileStoreAddress')->name('profile.store.address');
            Route::get('choose_address','ProfileController@chooseAddress')->name('choose.address');
        });
        ########################## end profile

        #################### start Shop
        Route::group(['namespace'=>'shop'], function(){
            Route::get('shop','ShopController@getShop')->name('get.shop');
            Route::post('shop-load-more','ShopController@loadMore')->name('load.more');
            Route::get('get_causes_against_category/{id}','ShopController@get_causes_against_category')->name('category.filter');
            // price slider filter
            Route::post('price-filter', 'ShopController@priceFilter')->name('price.filter');
        });

        ################# end shop

        ############### start product single page
        Route::group(['namespace'=>'singlePage'],function(){
            Route::get('single-page/{id}', 'SinglePageController@getProoductSinglePage')->name('get-product-single-page');
        });
    });

    ###################### end front

    Route::group(['namespace'=>'Order'],function(){
        Route::post('place-order','OrderController@placeOrder')->name('place.order');
    });

    Route::group(['namespace'=>'staticPage'], function(){
        Route::get('/contactUs','ContactUsMessageController@message')->name('contact-us.message');
        Route::post('/insert-contactUs-message','ContactUsMessageController@insertMessage')->name('insert.contact-us.message');
    });


});


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');


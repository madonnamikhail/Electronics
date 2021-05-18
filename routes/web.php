<?php

use App\Models\Address;
use App\Models\City;
use App\Models\Region;
use App\User;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Middleware\ValidateSignature;
 use Illuminate\Support\Facades\URL;

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
Route::group(['prefix'=>LaravelLocalization::setLocale() , 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],function(){

    Route::group(['namespace'=>'Front'], function(){
        Route::get('/','IndexController@index');
        Route::post('/search-box','IndexController@searchBox')->name('search.box');
        Route::post('/search-button','IndexController@searchBoxbutton')->name('search.box.button');
        Route::get('/index', 'IndexController@index')->name('index.page');
        Route::get('/hot_deals/{id}', 'IndexController@hotDeals')->name('hot.deals');
           #################### start Shop
        Route::group(['namespace'=>'shop'], function(){
            Route::get('shop','ShopController@getShop')->name('get.shop');
            Route::post('shop-load-more','ShopController@loadMore')->name('load.more');
            // Route::get('get_causes_against_category/{id}','ShopController@get_causes_against_category')->name('category.filter');
            // price slider filter
            // Route::post('price-filter', 'ShopController@priceFilter')->name('price.filter');
            //brand filter
            // Route::get('get-brand/{id}','ShopController@getbrand')->name('get.brand');
            // Route::get('get-subcategory/{id}','ShopController@getSubcategory')->name('get.subcategory');

            // multi filter
            Route::get('filter','ShopController@filtering')->name('filter');///{cat_id}/{subs_id}

            //shop of a specific category
            Route::get('category/{id}','ShopController@getProductsByCategoryId')->name('get.products.by.category.id');

            //shop of a specific subcategory
            Route::get('subcategory/{id}','ShopController@getProductsBySubcategoryId')->name('get.products.by.subcategory.id');

            //shop of a specific brand
            Route::get('brand/{id}','ShopController@getProductsByBrandId')->name('get.products.by.brand.id');

        });

            ################# end shop

        ############### start product single page
        Route::group(['namespace'=>'singlePage'],function(){
            Route::get('single-page/{id}', 'SinglePageController@getProoductSinglePage')->name('get-product-single-page');
        });

    });
    Route::group(['namespace'=>'staticPage'], function(){
        Route::get('/contactUs','ContactUsMessageController@message')->name('contact-us.message');
        Route::post('/insert-contactUs-message','ContactUsMessageController@insertMessage')->name('insert.contact-us.message');
    });


});

Route::group(['prefix'=>LaravelLocalization::setLocale() , 'middleware' => ['verified','localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],function(){

    ###################### front
    Route::group(['namespace'=>'Front'], function(){
        Route::post('/user-cart','IndexController@addCart')->name('add.to.cart');
        Route::get('/cart', 'IndexController@getCart')->name('get.cart');
        Route::post('/cart-clear', 'IndexController@cartClear')->name('cart.clear');



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
            Route::get('/rating/product','ProfileController@ProductRating')->name('product.rating');
            Route::post('/rating/product/insert','ProfileController@ProductRatingInsert')->name('insert');


            ####### changing user data
            Route::post('/profile/changing-info', 'ProfileController@profileChangeInfo')->name('profile.change.info');
            Route::post('/profile/changing-email', 'ProfileController@profileChangeEmail')->name('profile.change.email');
            Route::get('/check-url/{id}/{email}', function ($id,$email) {
                $data=[];
                $data['email']=$email;
                User::where('id','=', $id)->update($data);
                $user_info = User::find($id);
                $regions = Region::get();
                $cities = City::get();
                $addresses = Address::where('user_id', '=', $id)->get();
                return view('front.profile',compact('user_info','regions','cities','addresses'))->with('Success','your email has been updated successfully');
            })->name('check.url')->middleware('signed');
            Route::post('/profile/changing-password', 'ProfileController@profileChangePassword')->name('profile.change.password');

            Route::get('/profile/editing-address/{id}','ProfileController@profileEditAddress')->name('profile.edit.address');
            Route::post('/profile/changing-address/{id}', 'ProfileController@profileChangeAddress')->name('profile.change.address');
            Route::delete('/profile/deleting-address','ProfileController@profileDeleteAddress')->name('profile.delete.address');
            //if previous=1 comes from profile if previous=0 comes from cart
            Route::get('/profile/creating-address','ProfileController@profileCreateAddress')->name('profile.create.address');
            Route::post('/profile/storing-address','ProfileController@profileStoreAddress')->name('profile.store.address');
            Route::get('choose_address','ProfileController@chooseAddress')->name('choose.address');
        });
        ########################## end profile

        Route::group(['namespace'=>'singlePage'],function(){
            Route::post('/user-cart-single-page','SinglePageController@singlePageAddCart')->name('single.page.add.to.cart');
        });

    });

        ###################### end front

    Route::group(['namespace'=>'Order'],function(){
        Route::post('place-order','OrderController@placeOrder')->name('place.order');
    });



});


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');


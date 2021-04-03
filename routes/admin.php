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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');


#########################ADMIN LOGIN FORM AND GUARD##################
Route::group(['prefix'=>LaravelLocalization::setLocale() , 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],function(){


    Route::group(['prefix' => 'admin' , 'namespace'=> 'admin'], function () {
            Route::get('/admin','LoginController@dashboard')->middleware('auth:admin')->name('admin.Dashboard');
            Route::get('/login','LoginController@getLogin')->name('admin.get.login');
            Route::post('/logged-in','LoginController@Loggedin')->name('admin.login');
    });

        #########categories################
    Route::group(['prefix'=>'admin', 'namespace'=>'Admin'], function(){
        Route::get('show','CrudController@show')->name('all.categorys');
        //add new category 'role:super-admin','permission:publish articles'
        // Route::group(['middleware'=>['role:DbAdmin']],function(){
            Route::get('create','CrudController@create');
            Route::post('store','CrudController@store')->name('create.category');
            //edit category
            Route::get('edit/{id}','CrudController@edit')->name('edit.category');
            Route::post('update/{id}','CrudController@update')->name('update.category');
            //delete category
            Route::delete('delete','CrudController@delete')->name('delete.category');
        // });
    });


    Route::group(['prefix' => 'admin/subcat' , 'namespace'=> 'Admin'], function () {
        //to get subCategories of specified category
        //show
        Route::get('showw','CrudController@ssubshow')->name('show-all-subcategory');
        Route::get('show/{id}','CrudController@subshow');
        //add new sub category
        // Route::group(['middleware'=>['role:DbAdmin|SuperAdmin']],function(){
            Route::get('create','CrudController@subcreate');
            Route::post('store','CrudController@substore')->name('store.subcategory');
            //edit sub-category
            Route::get('edit/{id}','CrudController@subedit')->name('edit.subcategory');
            Route::post('update/{id}','CrudController@subupdate')->name('update.subcategory');
            //delete
            Route::delete('delete','CrudController@subdelete')->name('delete.subcategory');
        // });
    });

        ########################products#######################
        Route::group(['prefix' => 'admin/product' , 'namespace'=>'products' ], function () {
        //show without id
        Route::get('show-all','ProductController@showall');
        Route::get('show/{id}','ProductController@show')->name('show.product');
        //add
        Route::get('create','ProductController@create');
        Route::post('store','ProductController@store')->name('store.product');
        //edit
        Route::get('edit/{id}','ProductController@edit')->name('edit.product');
        Route::post('update/{id}','ProductController@update')->name('update.product');
        //delete
        Route::delete('delete','ProductController@delete')->name('delete.product');

        });

        ####################Brands########################
        Route::group(['prefix' => 'admin/brand' , 'namespace'=>'Brand' ], function () {
            //show without id
            Route::get('show-all','BrandController@showall');
            // //add
            Route::get('create','BrandController@create');
            Route::post('store','BrandController@store')->name('add.brand');
            // //edit
            Route::get('edit/{id}','BrandController@edit');
            Route::post('update/{id}','BrandController@update')->name('update.brand');
            // //delete
            Route::delete('delete','BrandController@delete')->name('delete.brand');

            });
            #########################OFFERS##################
            Route::group(['prefix' => 'admin/offer','namespace'=>'offer'],function(){
                Route::get('all-offers','OfferController@alloffers')->name('all.offers');
                //show offers product
                Route::get('show-offers-product/{id}','OfferController@showOffersProduct')->name('offers.product');
                Route::post('add-offers-product','OfferController@addProductstoOffer')->name('offers.product.add');

                //add offer
                Route::get('create','OfferController@create')->name('add.offer');
                 Route::post('store','OfferController@store')->name('store.offer');
                  // //edit
                Route::get('edit/{id}','OfferController@edit')->name('edit.offer');
                Route::post('update/{id}','OfferController@update')->name('update.offer');
                 //delete
                 Route::delete('delete','OfferController@delete')->name('delete.offer');
                 Route::delete('delete-product-from-offer','OfferController@deleteProductFromOffer')->name('delete.product.offer');

            });

            #########################suppliers##################
            Route::group(['prefix' => 'admin/supplier','namespace'=>'supplier'],function(){
                //show-all
                Route::get('all-suppliers','SupplierController@allsuppliers')->name('all.suppliers');
                    //show supplier products
                Route::get('show-Supplier-products/{id}','SupplierController@SupplierProducts')->name('show-Supplier-products');

                //add Supplier
                Route::get('create','SupplierController@create')->name('add.supplier');
                Route::post('store','SupplierController@store')->name('store.supplier');
                // //edit
                Route::get('edit/{id}','SupplierController@edit')->name('edit.supplier');
                Route::post('update/{id}','SupplierController@update')->name('update.supplier');
                    //delete
                    Route::delete('delete','SupplierController@delete')->name('delete.supplier');
        });

            #########################promocode##################
            Route::group(['prefix' => 'admin/promocode','namespace'=>'promocode'],function(){
            //show-all
            Route::get('all-promocodes','PromocodeController@allPromocodes')->name('all.promocodes');
            //add Supplier
            Route::get('create','PromocodeController@create')->name('add.promocode');
            Route::post('store','PromocodeController@store')->name('store.promocode');
            // //edit
            Route::get('edit/{id}','PromocodeController@edit')->name('edit.promocode');
            Route::post('update/{id}','PromocodeController@update')->name('update.promocode');
                //delete
            Route::delete('delete','PromocodeController@delete')->name('delete.promocode');
              });

        Route::group(['prefix'=>'admin/message','namespace'=>'Admin\Message'],function(){
            Route::get('show-message','MessageController@showMessage')->name('show.Message');
            //delete message
            Route::delete('delete-message','MessageController@delete')->name('delete.Message');
            Route::get('update/{id}/{action}','MessageController@update')->name('update.Message');

        });
        Route::group(['prefix'=>'admin/order','namespace'=>'Admin\Order'],function(){
            Route::get('show-order','OrderCrudController@show')->name('show.order');
            Route::get('order-products/{id}','OrderCrudController@orderProducts')->name('order.product');
            // add order (Ajax):
            // 1)
            Route::get('add-order','OrderCrudController@add')->name('add.order');
            // 2)
            Route::get('get-subcategories', 'OrderCrudController@getSubcategoriesByCategoryId')->name('get.subcategory.by.category_id');

            //3)
            Route::get('get-products', 'OrderCrudController@getProductsBySubcategoryId');


            // 4) save to cart
            Route::get('get-user','OrderCrudController@getUser')->name('get.user');
            Route::post('select-user','OrderCrudController@selectUserAndAddToCart')->name('select.user');
            Route::get('admin-show-cart/{user_id}','OrderCrudController@AdminShowCart')->name('admin.show.cart');
            Route::delete('admin-delete-cart','OrderCrudController@AdminCartProductDelete')->name('admin.cart.product.delete');
            Route::post('admin-add-cart','OrderCrudController@adminAddToCart')->name('admin.add.to.cart');

            // 5) add fl orders && order-product
            Route::get('admin-proceed-checkout/{user_id}','OrderCrudController@adminProceedToCheckout')->name('admin.proceed.checkout');

            Route::post('admin-place-order','OrderCrudController@adminPlaceOrder')->name('admin.place.order');

            //update
            Route::get('update/{id}/{action}','OrderCrudController@update')->name('update.order');
            // //delete
            Route::delete('delete-order','OrderCrudController@delete')->name('delete.order');
            // Route::get('update/{id}/{action}','MessageController@update')->name('update.Message');
        });

        Route::group(['prefix' => 'admin/cart','namespace'=>'Admin\Cart'],function(){
            //show-all
            Route::get('all-carts','CartController@allCarts')->name('all.carts');
            Route::get('show-cart/{id}','CartController@showCart')->name('show.cart');
            //update
            Route::get('update/{id}/{action}','CartController@update')->name('update.cart');
            // //delete
            Route::delete('delete','CartController@delete')->name('delete.cart');
        });


        ########################## citys ######################
        Route::group(['prefix' => 'admin/city','namespace'=>'Admin\city'],function(){
            //show-all
            Route::get('all-cities','CityControler@allCities')->name('all.cities');
            //add Supplier
            Route::get('create','CityControler@create')->name('add.city');
            Route::post('store','CityControler@store')->name('store.city');
            // //edit
            Route::get('edit/{id}','CityControler@edit')->name('edit.city');
            Route::post('update/{id}','CityControler@update')->name('update.city');
                //delete
            Route::delete('delete','CityControler@delete')->name('delete.city');
              });
        ########################### end citys #####################


        ########################## regions ######################
        Route::group(['prefix' => 'admin/region','namespace'=>'Admin\region'],function(){
            //show-all
            Route::get('all-region/{id}','RegionController@allCityRegions')->name('all.city.regions');
            Route::get('all-region','RegionController@allRegions')->name('all.regions');
            //add Supplier
            Route::get('create','RegionController@create')->name('add.region');
            Route::post('store','RegionController@store')->name('store.region');
            // //edit
            Route::get('edit/{id}','RegionController@edit')->name('edit.region');
            Route::post('update/{id}','RegionController@update')->name('update.region');
                //delete
            Route::delete('delete','RegionController@delete')->name('delete.region');
              });
        ########################### end regions #####################


        ########################## address ######################
        Route::group(['prefix' => 'admin/address','namespace'=>'Admin\address'],function(){
            //show-all
            Route::get('all-address/{id}','AddressController@allRegionsAddress')->name('all.region.address');
            Route::get('all-address','AddressController@allAddress')->name('all.address');
            //add Supplier
            Route::get('create','AddressController@create')->name('add.address');
            Route::post('store','AddressController@store')->name('store.address');
            // //edit
            Route::get('edit/{id}','AddressController@edit')->name('edit.address');
            Route::post('update/{id}','AddressController@update')->name('update.address');
                //delete
            Route::delete('delete','AddressController@delete')->name('delete.address');
              });
        ########################### end address #####################


        ######### static pages ################
    Route::group(['prefix'=>'admin/staticPages' ,'namespace'=>'Admin\Statics'], function(){
        Route::get('show','StaticPageController@show')->name('all.staticPages');
        //add new staticPage
        Route::get('create','StaticPageController@create')->name('add.staticPage');
        Route::post('store','StaticPageController@store')->name('create.staticPage');
        //edit staticPage
        Route::get('edit/{id}','StaticPageController@edit')->name('edit.staticPage');
        Route::post('update/{id}','StaticPageController@update')->name('update.staticPage');
        //delete staticPage
        Route::delete('delete','StaticPageController@delete')->name('delete.staticPage');
    });

    ########################users###############################
        Route::group(['prefix'=>'admin/user' ,'namespace'=>'Admin\User'], function(){
            Route::get('show','UserController@show')->name('all.users');
            //add new user
            Route::get('create','UserController@create')->name('add.user');
            Route::post('store','UserController@store')->name('create.user');
            // //edit user
            Route::get('edit/{id}','UserController@edit')->name('edit.user');
            Route::post('update/{id}','UserController@update')->name('update.user');
            // //delete user
            Route::delete('delete','UserController@delete')->name('delete.user');

        });
});








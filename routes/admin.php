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
        //add new category
        Route::get('create','CrudController@create');
        Route::post('store','CrudController@store')->name('create.category');
        //edit category
        Route::get('edit/{id}','CrudController@edit')->name('edit.category');
        Route::post('update/{id}','CrudController@update')->name('update.category');
        //delete category
        Route::delete('delete','CrudController@delete')->name('delete.category');
    });


    Route::group(['prefix' => 'admin/subcat' , 'namespace'=> 'Admin'], function () {
        //to get subCategories of specified category
        //show
        Route::get('showw','CrudController@ssubshow')->name('show-all-subcategory');
        Route::get('show/{id}','CrudController@subshow');
        //add new sub category
        Route::get('create','CrudController@subcreate');
        Route::post('store','CrudController@substore')->name('store.subcategory');
        //edit sub-category
        Route::get('edit/{id}','CrudController@subedit');
        Route::post('update/{id}','CrudController@subupdate')->name('update.subcategory');
        //delete
        Route::delete('delete','CrudController@subdelete')->name('delete.subcategory');
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

});








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
            Route::post('/logout','LoginController@logout')->name('admin.logout');
    });



    Route::group(['middleware'=>'auth:admin'], function(){
        Route::group(['prefix'=>'admin/role','namespace'=>'Admin\Role'],function(){
            Route::get('show','RoleController@show')->name('all.roles');
            Route::get('create-role','RoleController@create')->name('create.role');
            Route::post('store-role','RoleController@store')->name('store.role');
            Route::get('edit-role/{role_id}','RoleController@edit')->name('edit.role.permissions');
            Route::post('update-role/{role_id}','RoleController@update')->name('update.role.permissions');
            Route::delete('delete-role','RoleController@delete')->name('delete.role.permission');
        });
        Route::group(['prefix'=>'admin/permission','namespace'=>'Admin\Permission'],function(){
            Route::get('show','PermissionController@show')->name('all.permissions');
            Route::get('create-permission','PermissionController@create')->name('create.permission');
            Route::post('store-permission','PermissionController@store')->name('store.permission');
            Route::get('edit-permission/{permission_id}','PermissionController@edit')->name('edit.permissions.role');
            Route::post('update-permission/{permission_id}','PermissionController@update')->name('update.permissions.role');
            Route::delete('delete-permission','PermissionController@delete')->name('delete.permissions.role');
        });
        Route::group(['prefix'=>'admin/admin','namespace'=>'Admin\crudAdmin'],function(){
            Route::get('show','AdminController@show')->name('all.admins');
            Route::get('create-admin','AdminController@create')->name('create.admin');
            Route::post('store-admin','AdminController@store')->name('store.admin');
            Route::get('edit-admin/{admin_id}','AdminController@edit')->name('edit.admin');
            Route::post('update-admin/{admin_id}','AdminController@update')->name('update.admin');
            Route::delete('delete-admin','AdminController@delete')->name('delete.admin');
        });
     #########categories################
        Route::group(['prefix'=>'admin', 'namespace'=>'Admin'], function(){
            Route::get('show','CrudController@show')->name('all.categorys');
            //add new category 'role:super-admin','permission:publish articles'
            // Route::group(['middleware'=>['role:DbAdmin']],function(){
                Route::get('create','CrudController@create');
                Route::post('store','CrudController@store')->name('create.category');
                //edit category
                Route::get('edit/{id}','CrudController@edit')->name('edit.category')->middleware(['role:writer']);
                Route::post('update/{id}','CrudController@update')->name('update.category')->middleware(['role:writer']);
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
            Route::get('show-all','ProductController@showall')->name('show.all.product');
            Route::get('show/{id}','ProductController@show')->name('show.product');
            //add
            Route::get('create','ProductController@create');
            Route::post('store','ProductController@store')->name('store.product');
            //edit
            Route::get('edit/{id}','ProductController@edit')->name('edit.product');
            Route::post('update/{id}','ProductController@update')->name('update.product');
            //delete
            Route::delete('delete','ProductController@delete')->name('delete.product');
            //show product specs
            Route::get('show-product-spec/{product_id}','ProductController@showProductSpec')->name('show.product.specs');
            //edit spec value
            Route::get('edit-product-spec/{product_id}/{spec_id}','ProductController@editProductSpec')->name('edit.product.specs');
            Route::post('update-product-spec','ProductController@updateProductSpec')->name('update.product.specs');
            //delete spec from product
            Route::delete('delete-spec-from-product','ProductController@deleteSpecFromProduct')->name('delete.spec.from.product');






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
                Route::get('order-products/{id}/{user_id}','OrderCrudController@orderProducts')->name('order.product');
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

                Route::get('appologize/{product_id}/{user_id}/{order_id}','OrderCrudController@appologize')->name('appologize');
                Route::get('new-oredr','OrderCrudController@getneworder')->name('get.new.order');

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
                //show user-orders
                Route::get('user-order/{user_id}','UserController@userOrder')->name('user.order');

            });


        ########################## speccs ######################
        Route::group(['prefix' => 'admin/specc','namespace'=>'Admin\specc'],function(){
            //show-all
            Route::get('all-speccs','SpeccController@allSpeccs')->name('all.speccs');
            //add Supplier
            Route::get('create','SpeccController@create')->name('add.specc');
            Route::post('store','SpeccController@store')->name('store.specc');
            // //edit
            Route::get('edit/{id}','SpeccController@edit')->name('edit.specc');
            Route::post('update/{id}','SpeccController@update')->name('update.specc');
                //delete
            Route::delete('delete','SpeccController@delete')->name('delete.specc');
            Route::get('add-sepcc-to-product','SpeccController@addSpecToProduct')->name('add.specc.product');
            Route::post('store-sepcc-to-product','SpeccController@storeSpecToProduct')->name('store.specc.product');
            Route::get('show-sepcc-products/{spec_id}','SpeccController@showSpecProducts')->name('show.specc.product');
            Route::Delete('deattach-product-from-spec','SpeccController@deattachProductFromSpec')->name('deattach.product.specc');

        });
        ########################### end citys #####################
    });

});








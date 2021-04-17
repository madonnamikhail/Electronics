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
Route::group(['prefix'=>LaravelLocalization::setLocale() , 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){
    Route::group(['prefix'=>'supplier','namespace'=>'SupplierDashboard','middlewaare'=>'guest:supplier'], function(){
        Route::get('login-form','SupplierDashoardController@supplierLoginForm')->name('supplier-login-form');
        Route::post('login','SupplierDashoardController@supplierLogin')->name('supplier-login');
    });
    Route::group(['prefix'=>'supplier','namespace'=>'SupplierDashboard','middleware'=>'auth:supplier'], function(){
        Route::get('/supplier','SupplierDashoardController@index')->name('supplier-dashboard');

        // Supplier's Products
        Route::group(['prefix'=>'product','namespace'=>'SupplierProduct'], function(){
            Route::get('show-supplier-products','SupplierProductController@showSupplierProducts')->name('show-supplier-products');
            // change product's status via check box (delayed)
            Route::post('update-product-status','SupplierProductController@updateProductStatus')->name('update-product-status');

            // suppplier CRUDs product
            Route::get('supplier-create','SupplierProductController@create')->name('supplier.create.product');
            Route::post('supplier-store','SupplierProductController@store')->name('supplier.store.product');
            //edit
            Route::get('supplier-edit/{id}','SupplierProductController@edit')->name('supplier.edit.product');
            Route::post('supplier-update/{id}','SupplierProductController@update')->name('supplier.update.product');
            //delete
            Route::delete('supplier-delete','SupplierProductController@delete')->name('supplier.delete.product');
        });
        Route::group(['prefix'=>'order','namespace'=>'SupplierOrder'], function(){
            // suppplier CRUDs order
                // 1) get created orders
                    Route::get('supplier-created-orders','SupplierOrderController@getCreatedOrders')->name('supplier.created.orders');
                // 2) get in progress orders
                    Route::get('supplier-inprogress-orders','SupplierOrderController@getInProgressOrders')->name('supplier.inprogress.orders');
                // 3) get delivered orders
                    Route::get('supplier-delivered-orders','SupplierOrderController@getDeliveredOrders')->name('supplier.delivered.orders');
                // 4) update order's status
                    // Route::get('supplier-update-order/{id}','OrderCrudController@update')->name('supplier.update.order');
            
            // supplier can/cannot deliver the product
                // 1) suppplier can deliver product
                    Route::get('supllier-can-deliver/{product_id}/{order_id}','SupplierOrderController@supplierCanDeliver')->name('supplier.can.deliver');
                // 2) suppplier cannot deliver product
                    Route::get('supllier-cannot-deliver/{product_id}/{order_id}','SupplierOrderController@supplierCannotDeliver')->name('supplier.cannot.deliver');
        });
    });
});

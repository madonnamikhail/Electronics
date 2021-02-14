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
Route::group(['prefix' => 'admin' , 'namespace'=> 'admin'], function () {
    Route::get('/admin','LoginController@dashboard')->middleware('auth:admin')->name('admin.Dashboard');
    Route::get('/login','LoginController@getLogin')->name('admin.get.login');
    Route::post('/logged-in','LoginController@Loggedin')->name('admin.login');
});

#########################ADMIN LOGIN FORM AND GUARD##################

#########categories################
//show all
Route::get('admin/show','Admin\CrudController@show')->name('all.categorys');
//add new category
Route::get('admin/create','Admin\CrudController@create');
Route::post('admin/store','Admin\CrudController@store')->name('create.category');
//edit category
Route::get('admin/edit/{id}','Admin\CrudController@edit')->name('edit.category');
Route::post('admin/update/{id}','Admin\CrudController@update')->name('update.category');
//delete category
Route::delete('admin/delete','Admin\CrudController@delete')->name('delete.category');

//to get subCategories of specified category
//show
Route::get('admin/subcat/show/{id}','Admin\CrudController@subshow');
//add new sub category
Route::get('admin/subcat/create','Admin\CrudController@subcreate');
Route::post('admin/subcat/store','Admin\CrudController@substore');
//edit sub-category
Route::get('admin/subcat/edit/{id}','Admin\CrudController@subedit');
Route::post('admin/subcat/update/{id}','Admin\CrudController@subupdate');
//delete
Route::delete('admin/subcat/delete','Admin\CrudController@subdelete');


#########end categories################
########################products#######################
Route::group(['prefix' => 'admin/product' , 'namespace'=>'products' ], function () {
    Route::get('show/{id}','ProductController@show')->name('show.product');
    //add
    Route::get('create','ProductController@create');
    Route::post('store','ProductController@store');
    //edit
});


###########AJax##########
Route::group(['prefix' => 'ajax','namespace' => 'Ajax'], function () {
        Route::get('create','CategoryController@create');
        Route::post('store','CategoryController@store')->name('ajax.store');
        Route::post('subcategorystore','SubCategoryController@Store')->name('ajax.sub.store');


});

###########END AJAX#################

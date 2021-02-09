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
Route::get('admin/show','Admin\CrudController@show')->name('all.categorys');
Route::get('admin/create','Admin\CrudController@create');

#########end categories################



###########AJax##########
Route::group(['prefix' => 'ajax','namespace' => 'Ajax'], function () {
        Route::get('create','CategoryController@create');
        Route::post('store','CategoryController@store')->name('ajax.store');
});

###########END AJAX#################

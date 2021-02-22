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

        Route::get('/index', function () {
            return view('front.userindex');
        });

});








Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');


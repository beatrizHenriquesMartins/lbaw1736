<?php

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
    return redirect('homepage');
});

// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

// Homepage

Route::get('homepage', 'HomepageController@show')->name('homepage');

// wishlist
Route::get('wishlist', 'WishlistController@list')->name('wishlist');


// 404
Route::get('404', 'FooterController@show404')->name('404');

// Footer
Route::get('aboutus', 'FooterController@showaboutus')->name('aboutus');
Route::get('faq', 'FooterController@showfaq')->name('faq');
Route::get('contactus', 'FooterController@showcontactus')->name('contactus');
Route::get('terms', 'FooterController@showterms')->name('terms');

// cart
Route::get('cart', 'CartController@list')->name('cart');


// product
Route::get('products/{id}', 'ProductController@show');

// Authentication

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

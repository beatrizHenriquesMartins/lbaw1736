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

// Homepage

Route::get('homepage', 'HomepageController@show')->name('homepage');

// wishlist
Route::get('wishlist', 'WishlistController@list')->name('wishlist');
Route::delete('api/wishlist/{id}', 'WishlistController@delete');
Route::put('api/wishlist/{id}', 'WishlistController@create');


// Footer
Route::get('404', 'FooterController@show404')->name('404');
Route::get('aboutus', 'FooterController@showaboutus')->name('aboutus');
Route::get('contactus', 'FooterController@showcontactus')->name('contactus');
Route::get('faq', 'FooterController@showfaq')->name('faq');
Route::get('terms', 'FooterController@showterms')->name('terms');


// cart
Route::get('cart', 'CartController@list')->name('cart');
Route::delete('api/cart/{id}', 'CartController@delete');
Route::delete('api/cart', 'CartController@deleteAll');
Route::put('api/cart/{id}', 'CartController@create');


// product
Route::get('products/{id}', 'ProductController@show');
Route::get('products/{id}/edit', 'ProductController@edit')->name('editProduct');
Route::get('products/{id}/remove', 'ProductController@delete')->name('removeProduct');
Route::get('category/{categoryName}', 'ProductController@showCategory')->name('category');

// Authentication

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

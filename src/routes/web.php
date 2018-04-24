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

// purchases
Route::get('purchases', 'PurchaseController@list')->name('purchases');

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
Route::post('api/cart/{id}/quantity/{quantity}', 'CartController@update');


// product
Route::get('products/{id}', 'ProductController@show')->name('product');
Route::get('products/{id}/edit', 'ProductController@showedit')->name('editProduct');
Route::get('products/{id}/remove', 'ProductController@delete')->name('removeProduct');
Route::get('newproduct', 'ProductController@showadd')->name('newProduct');
Route::post('addproduct', 'ProductController@create')->name('addProduct');
Route::post('products/{id}/editproduct', 'ProductController@edit')->name('editproduct');

//Reivew
Route::post('addreview/{id_product}/{id_purchase}', 'ReviewController@create')->name('addreview');

// category
Route::get('category/{categoryName}', 'ProductController@showCategory')->name('category');

// category
Route::get('brands/{brandName}', 'ProductController@showBrand')->name('brand');

// Authentication

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

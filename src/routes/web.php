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
Route::post('addwishlist/{product_id}', 'WishlistController@create')->name('addwishlist');
Route::post('removewishlist/{product_id}', 'WishlistController@delete')->name('removeWishlist');
/*
Route::get('addwishlist/{product_id}', '['as' => 'addWishlist', function (Request $id, $product_id) {
    echo $product_id;
}]');*/
// Footer
Route::get('404', 'FooterController@show404')->name('404');
Route::get('aboutus', 'FooterController@showaboutus')->name('aboutus');
Route::get('contactus', 'FooterController@showcontactus')->name('contactus');
Route::get('faq', 'FooterController@showfaq')->name('faq');
Route::get('terms', 'FooterController@showterms')->name('terms');


// cart
Route::get('cart', 'CartController@list')->name('cart');
Route::post('addcart/{product_id}', 'CartController@create')->name('addCart');
Route::post('removecart/{product_id}', 'CartController@delete')->name('removeCart');
Route::post('removeallcart/', 'CartController@deleteAll')->name('removeAllCart');


// product
Route::get('products/{id}', 'ProductController@show');

// Authentication

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

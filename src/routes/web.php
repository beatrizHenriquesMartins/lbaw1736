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
Route::post('contactusmail', 'FooterController@contactus')->name('contactusmail');


// cart
Route::get('cart', 'CartController@list')->name('cart');
Route::delete('api/cart/{id}', 'CartController@delete');
Route::delete('api/cart', 'CartController@deleteAll');
Route::put('api/cart/{id}', 'CartController@create');
Route::post('api/cart/{id}/quantity/{quantity}', 'CartController@update');

//cart_order
Route::get('cart_order', 'CartOrderController@show')->name('cart_order');
//cart payment
Route::post('cart_payment', 'CartPaymentController@show')->name('cart_payment');
Route::post('api/payment/{address_id}/nif/{nif}', 'CartPaymentController@processPayment');


// product
Route::get('products/{id}', 'ProductController@show')->name('product');
Route::get('products/{id}/edit', 'ProductController@showedit')->name('editProduct');
Route::get('products/{id}/remove', 'ProductController@delete')->name('removeProduct');
Route::get('newproduct', 'ProductController@showadd')->name('newProduct');
Route::post('addproduct', 'ProductController@create')->name('addProduct');
Route::post('products/{id}/editproduct', 'ProductController@edit')->name('editproduct');
Route::get('search', 'ProductController@search')->name('search');

//Reivew
Route::post('addreview/{id_product}/{id_purchase}', 'ReviewController@create')->name('addreview');
Route::delete('api/remove/comment', 'ReviewController@delete');

// category
Route::get('category/{categoryName}', 'ProductController@showCategory')->name('category');

// category
Route::get('brands/{brandName}', 'ProductController@showBrand')->name('brand');
Route::get('BMbrands', 'ProductController@BMbrands')->name('brands');
Route::get('addbrand', 'ProductController@showAddBrand')->name('addbrand');
Route::post('addbrand', 'ProductController@addBrand');

// Authentication

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// administration
Route::get('clients', 'AdminController@listClients')->name('clients');
Route::get('bms', 'AdminController@listBms')->name('bms');
Route::get('supports', 'AdminController@listSupports')->name('supports');
Route::get('bans', 'AdminController@listBans')->name('bans');
Route::post('api/users/ban', 'AdminController@ban');

Route::post('api/users/unban', 'AdminController@unban');
Route::get('users/{id}', 'AdminController@showUser');
Route::get('confirm_payment', 'AdminController@confirmPaymentShow');
Route::get('validate_payment/{id}', 'AdminController@validatePayment');

// profile
Route::get('profile', 'ProfileController@show')->name('profile');
Route::get('profile/edit', 'ProfileController@showedit')->name('showEditProfile');
Route::post('profile/edit', 'ProfileController@edit')->name('editProfile');
Route::delete('api/remove/address', 'ProfileController@removeAddress');
Route::put('api/add/address', 'ProfileController@addAddress');


//messages
Route::get('messages/{id}','SupportMessagesController@showMessage')->name('messages');
Route::post('api/message','ClientController@newMessage');
Route::get('api/getmessages','ClientController@getMessages');




Route::get('auth/reset/{token}', 'Auth\ForgotPasswordController@getResetAuthenticatedView')->name('auth.reset');
Route::post('auth/reset', 'Auth\ForgotPasswordController@resetNotAuthenticated');
Route::get('auth/email', 'Auth\ForgotPasswordController@getEmail');
Route::post('auth/email', 'Auth\ForgotPasswordController@sendEmail');
Route::post('googleauth', 'Auth\RegisterController@googleRegister');

<?php

use Illuminate\Support\Facades\Route;

// Home
Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index')->name('home');

// Contact
Route::post('/contact', 'HomeController@contact')->name('contact');

// Shop
Route::resource('shop', 'ShopController')->only(['index', 'show']);
Route::get('search', 'ShopController@search')->name('search');

// Cart
Route::resource('cart', 'CartController')->only(['index', 'store', 'destroy']);
Route::patch('cart/{product}', 'CartController@update')->name('cart.update');

// Wishlist
Route::resource('wishlist', 'WishlistController')->only(['index', 'store', 'destroy']);

// Checkout
Route::get('checkout', 'Checkout\CheckoutController@detailsIndex')->name('checkout.detailsIndex');
Route::post('checkout/validateDetails', 'Checkout\CheckoutController@validateDetails')->name('checkout.validateDetails');
Route::get('checkout/complete', 'Checkout\CheckoutController@completeIndex')->name('checkout.completeIndex');
Route::post('checkout', 'Checkout\CreditCardCheckoutController@store')->name('checkout.store');
Route::post('checkout/verify', 'Checkout\CreditCardCheckoutController@verify')->name('checkout.verify');
// Paypal
Route::post('checkout/paypal', 'Checkout\PaypalCheckoutController@store')->name('paypal-checkout.store');
Route::get('checkout/paypal/captureOrder', 'Checkout\PaypalCheckoutController@captureOrder')->name('paypal-checkout.captureOrder');

// Login checkout
Route::name('loginToCheckout')->get('loginToCheckout', 'Auth\LoginController@loginToCheckout');

// Coupon
Route::post('coupon', 'CouponController@store')->name('coupon.store');
Route::delete('coupon', 'CouponController@destroy')->name('coupon.destroy');

Route::get('thankyou', function() {
    // Delete "user_id" cookie
    setcookie('user_id', '', time()-3600);

	// Delete "cart" cookie
    setcookie('cart', '', time()-60);

	return view('thankyou');
})->name('thankyou');

Route::middleware('auth')->group(function() {
	Route::get('profile', 'UsersController@edit')->name('profile.edit');
	Route::put('profile', 'UsersController@update')->name('profile.update');
	
	Route::resource('orders', 'OrdersController')->only(['index', 'show']);
});

Route::group(['prefix' => 'admin'], function() {
    Voyager::routes();
});

Auth::routes();

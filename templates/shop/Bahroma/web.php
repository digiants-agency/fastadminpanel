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

Route::get('/sitemap.xml', 'SitemapController@index');

Route::group([
	'prefix' => Lang::prefix(),
	'middleware' => [
		\App\FastAdminPanel\Middleware\Lang::class,
		//\App\FastAdminPanel\Middleware\RedirectSEO::class,
	]
], function(){

	Route::get('/', 'PageController@index');
    Route::get('/about', 'PageController@about');
    Route::get('/contact', 'PageController@contact');
    Route::get('/delandpay', 'PageController@delandpay');
    Route::get('/successorder', 'PageController@successorder');
    Route::get('/privacypolicy', 'PageController@privacypolicy');
    Route::get('/page/{slug}', 'PageController@defaultpage');

    Route::get('/search', 'SearchController@index');
    Route::post('/search/ajaxsearch', 'SearchController@ajaxsearch');
    Route::post('/product/addtestim', 'ProductController@addtestim');

    Route::get('/blog/{slug}', 'BlogController@view');
    Route::get('/blog', 'BlogController@index');

    Route::get('/products/{slug}', 'CatalogController@view')->where('slug', '.*');
    Route::get('/products', 'CatalogController@index');

    Route::get('/order', 'CartController@order');
    Route::post('/cart/order', 'CartController@createorder');
    Route::get('/cart/order', 'CartController@createorder');
    Route::post('/cart/ajaxorder', 'CartController@ajaxcreateorder');
    Route::post('/cart/buyoneclick', 'CartController@buyoneclick');
    Route::post('/cart/wishlist', 'CartController@wishlist');
    Route::get('/cart/ajxorder', 'CartController@ajaxcreateorder');
    Route::post('/cart/callback', 'CartController@callback');
    Route::post('/user/signin', 'UserController@signin');
    Route::post('/user/signup', 'UserController@signup');
    Route::get('/user/clearwishlist', 'UserController@clearwish');
    Route::any('/user/logout', 'UserController@logout');
    Route::any('/user', 'UserController@view');
    Route::get('/{slug}', 'ProductController@view');
});

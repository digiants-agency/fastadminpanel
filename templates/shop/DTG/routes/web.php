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
		\App\FastAdminPanel\Middleware\Convertor::class,
		//\App\FastAdminPanel\Middleware\RedirectSEO::class,
	]
], function(){

	Route::get('/', 'PageController@index');
	Route::get('/contacts', 'PageController@contacts');
	Route::get('/about', 'PageController@about');

	Route::any('/blog', 'BlogController@blog')->name('blog');
	Route::get('/blog/{slug}', 'BlogController@article')->where('slug', '.*')->name('blog');
	
	Route::any('/projects', 'ProjectController@projects')->name('projects');
	Route::get('/projects/{slug}', 'ProjectController@project')->where('slug', '.*')->name('projects');

	Route::get('/catalog', 'PageController@catalog')->name('catalog');
	Route::any('/catalog/{category_slug}/{slug?}', 'ProductController@products')->where('slug', '.*')->name('catalog');
	Route::get('/product/{slug}', 'ProductController@product')->where('slug', '.*')->name('product');

	Route::any('/search', 'SearchController@search');

	Route::any('/user', 'UserController@user')->name('user');
	Route::any('/user/history', 'UserController@user')->name('userhistory');
	Route::any('/user/wished', 'UserController@user')->name('userwished');
	
	Route::get('/checkout', 'CheckoutController@checkout')->name('checkout');
	Route::get('/thanks', 'PageController@thanks')->name('thanks');

	Route::get('/{slug}', 'PageController@standart');

	Route::get('/np/update-all-warehouses', 'NovaPoshtaController@update_warehouses');

	Route::post('/api/show-more-reviews', 'ReviewController@show_more_reviews');
	Route::post('/api/send-review', 'ReviewController@send_review');
	Route::post('/api/send-horizontal', 'CallbackController@send_horizontal');
	Route::post('/api/send-contacts', 'CallbackController@send_contacts');
	Route::post('/api/send-modal', 'CallbackController@send_modal');
	Route::post('/api/search', 'SearchController@search_items');

	Route::post('/api/login', 'AuthController@login')->name('login');
	Route::post('/api/logout', 'AuthController@logout')->name('logout');
	Route::post('/api/register', 'AuthController@register')->name('register');
	Route::post('/api/sendcode', 'AuthController@sendcode')->name('sendcode');
	Route::post('/api/checkcode', 'AuthController@checkcode')->name('checkcode');
	Route::post('/api/changepassword', 'AuthController@changepassword')->name('changepassword');
	Route::post('/api/edit-user', 'UserController@edit')->name('edit-user');
	
	Route::post('/api/add-to-cart', 'CartController@add');
	Route::post('/api/change-delivery', 'CheckoutController@change_delivery');
	Route::post('/api/order', 'CheckoutController@order');
	Route::post('/api/get-city', 'CheckoutController@get_city');
	Route::post('/api/get-department', 'CheckoutController@get_warehouse');

	Route::post('/api/saved', 'SavedController@saved');
	Route::post('/api/saved/clear', 'SavedController@clear');


	Route::fallback(function () {
		return view("errors.404");
	});
});
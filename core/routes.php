<?php

use App\FastAdminPanel\Controllers\SingleController;
use App\FastAdminPanel\Controllers\LanguageController;

Route::group([
	'namespace'     => 'App\FastAdminPanel\Controllers',
], function() {

	Route::get('admin/newsletter/unsubscribe', 'NewsletterController@unsubscribe');
	Route::get('admin/newsletter/hit', 'NewsletterController@hit');

	Route::post('sign-in', 'FAPController@sign_in');
	Route::post('admin/logout', 'FAPController@logout');
	Route::get('login', 'FAPController@login');
	
	Route::group([
		'middleware'    => [\App\FastAdminPanel\Middleware\AdminOnly::class],
	], function() {

		Route::group(['prefix' => 'laravel-filemanager'], function () {
			\UniSharp\LaravelFilemanager\Lfm::routes();
		});
	
		Route::get('admin', 'FAPController@admin');

		Route::group([
			'prefix' => Lang::prefix(),
		], function() {

			Route::get('/admin/api/single/{id}',	[SingleController::class, 'get']);
			Route::put('/admin/api/single/{id}',	[SingleController::class, 'put']);
			Route::delete('/admin/api/single/{id}',	[SingleController::class, 'delete']);
		});

		Route::post('/admin/api/language/{tag}', 	[LanguageController::class, 'post']);
		Route::delete('/admin/api/language/{tag}',	[LanguageController::class, 'delete']);

		Route::post('admin/update-dropdown', 'ApiController@update_dropdown');
		Route::post('admin/get-menu', 'ApiController@get_menu');

		Route::post('admin/get-dynamic', 'ApiController@get_dynamic');
		Route::post('admin/set-dynamic', 'ApiController@set_dynamic');
		Route::post('admin/save-editable', 'ApiController@save_editable');

		Route::post('admin/db-copy', 'ApiController@db_copy');
		Route::post('admin/db-count', 'ApiController@db_count');
		Route::post('admin/db-select', 'ApiController@db_select');
		Route::post('admin/db-create-table', 'ApiController@db_create_table');
		Route::post('admin/db-remove-table', 'ApiController@db_remove_table');
		Route::post('admin/db-update-table', 'ApiController@db_update_table');
		Route::post('admin/db-remove-row', 'ApiController@db_remove_row');
		Route::post('admin/db-remove-rows', 'ApiController@db_remove_rows');

		Route::post('admin/upload-image', 'ApiController@upload_image');

		Route::post('admin/newsletter/get', 'NewsletterController@get');
		Route::post('admin/newsletter/add', 'NewsletterController@add');
		Route::post('admin/newsletter/rm', 'NewsletterController@rm');
		Route::post('admin/newsletter/letter/add', 'NewsletterController@letter_add');
		Route::post('admin/newsletter/letter/rm', 'NewsletterController@letter_rm');
		Route::post('admin/newsletter/letter/save', 'NewsletterController@letter_save');
		Route::post('admin/newsletter/base/add', 'NewsletterController@base_add');
		Route::post('admin/newsletter/base/rm', 'NewsletterController@base_rm');
		Route::post('admin/newsletter/base/download', 'NewsletterController@base_download');

		Route::post('/admin/get-mainpage', 'ApiController@get_mainpage');

		Route::get('admin/{any}', 'FAPController@admin')->where('any', '.*');
		
	});
});
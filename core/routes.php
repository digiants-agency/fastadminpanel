<?php

use App\FastAdminPanel\Controllers\SingleController;
use App\FastAdminPanel\Controllers\LanguageController;

Route::group([
	'namespace'     => 'App\FastAdminPanel\Controllers',
], function() {

	Route::post('/sign-in', 'FAPController@signIn');
	Route::post('/admin/logout', 'FAPController@logout');
	Route::get('/login', 'FAPController@login');
	
	Route::group([
		'middleware'    => [\App\FastAdminPanel\Middleware\AdminOnly::class],
	], function() {

		Route::group(['prefix' => 'laravel-filemanager'], function() {
			\UniSharp\LaravelFilemanager\Lfm::routes();
		});
	
		Route::get('/admin', 'FAPController@admin');

		Route::group([
			'prefix' => Lang::prefix(),
		], function() {

			Route::get('/admin/api/single/{id}',	[SingleController::class, 'show']);
			Route::put('/admin/api/single/{id}',	[SingleController::class, 'update']);
			Route::delete('/admin/api/single/{id}',	[SingleController::class, 'destroy']);
		});

		Route::post('/admin/api/language/{tag}', 	[LanguageController::class, 'post']);
		Route::delete('/admin/api/language/{tag}',	[LanguageController::class, 'delete']);

		Route::post('/admin/update-dropdown', 'ApiController@updateDropdown');
		Route::post('/admin/get-menu', 'ApiController@getMenu');

		Route::post('/admin/get-dynamic', 'ApiController@getDynamic');
		Route::post('/admin/set-dynamic', 'ApiController@setDynamic');
		Route::post('/admin/save-editable', 'ApiController@saveEditable');

		Route::post('/admin/db-copy', 'ApiController@dbCopy');
		Route::post('/admin/db-count', 'ApiController@dbCount');
		Route::post('/admin/db-select', 'ApiController@dbSelect');
		Route::post('/admin/db-create-table', 'ApiController@dbCreateTable');
		Route::post('/admin/db-remove-table', 'ApiController@dbRemoveTable');
		Route::post('/admin/db-update-table', 'ApiController@dbUpdateTable');
		Route::post('/admin/db-remove-row', 'ApiController@dbRemoveRow');
		Route::post('/admin/db-remove-rows', 'ApiController@dbRemoveRows');

		Route::post('/admin/upload-image', 'ApiController@uploadImage');

		Route::post('/admin/get-mainpage', 'ApiController@getMainpage');

		Route::get('/admin/{any}', 'FAPController@admin')->where('any', '.*');
	});
});
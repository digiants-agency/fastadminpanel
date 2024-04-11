<?php

use App\FastAdminPanel\Controllers\AdminController;
use App\FastAdminPanel\Controllers\DocsController;
use App\FastAdminPanel\Controllers\ImportExportController;
use App\FastAdminPanel\Controllers\SingleController;
use App\FastAdminPanel\Controllers\LanguageController;
use App\FastAdminPanel\Controllers\MigrationController;

Route::post('/sign-in', [AdminController::class, 'signIn']);
Route::post('/admin/logout', [AdminController::class, 'logout']);
Route::get('/login', [AdminController::class, 'login']);

Route::group([
	'middleware'    => [\App\FastAdminPanel\Middleware\AdminOnly::class],
], function() {

	Route::group(['prefix' => 'laravel-filemanager'], function() {
		\UniSharp\LaravelFilemanager\Lfm::routes();
	});

	Route::get('/admin', [AdminController::class, 'admin']);

	Route::group([
		'prefix' => Lang::prefix(),
	], function() {

		Route::get('/admin/api/single/{id}',	[SingleController::class, 'show']);
		Route::put('/admin/api/single/{id}',	[SingleController::class, 'update']);
		Route::delete('/admin/api/single/{id}',	[SingleController::class, 'destroy']);
	});

	Route::post('/admin/get-docs', [DocsController::class, 'index']);

	Route::post('/admin/api/language/{tag}', 	[LanguageController::class, 'post']);
	Route::delete('/admin/api/language/{tag}',	[LanguageController::class, 'delete']);

	Route::post('/admin/update-dropdown', [AdminController::class, 'updateDropdown']);
	Route::post('/admin/get-menu', [AdminController::class, 'getMenu']);

	Route::post('/admin/get-dynamic', [AdminController::class, 'getDynamic']);
	Route::post('/admin/set-dynamic', [AdminController::class, 'setDynamic']);
	Route::post('/admin/save-editable', [AdminController::class, 'saveEditable']);

	Route::post('/admin/db-copy', [AdminController::class, 'dbCopy']);
	Route::post('/admin/db-count', [AdminController::class, 'dbCount']);
	Route::post('/admin/db-select', [AdminController::class, 'dbSelect']);
	Route::post('/admin/db-remove-row', [AdminController::class, 'dbRemoveRow']);
	Route::post('/admin/db-remove-rows', [AdminController::class, 'dbRemoveRows']);

	Route::post('/admin/db-create-table', [MigrationController::class, 'createTable']);
	Route::post('/admin/db-remove-table', [MigrationController::class, 'removeTable']);
	Route::post('/admin/db-update-table', [MigrationController::class, 'updateTable']);

	Route::post('/admin/single-edit', [SingleController::class, 'singleEdit']);
	Route::post('/admin/single-remove', [SingleController::class, 'singleRemove']);

	Route::post('/admin/upload-image', [AdminController::class, 'uploadImage']);

	Route::post('/admin/get-mainpage', [AdminController::class, 'getMainpage']);

	Route::get('/admin/export/{table}', [ImportExportController::class, 'export'])->name('admin-export');
	Route::post('/admin/import/{table}', [ImportExportController::class, 'import'])->name('admin-import');	
	
	Route::get('/admin/{any}', [AdminController::class, 'admin'])->where('any', '.*');
});
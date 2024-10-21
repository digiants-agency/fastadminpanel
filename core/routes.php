<?php

use App\FastAdminPanel\Controllers\AuthController;
use App\FastAdminPanel\Controllers\CrudController;
use App\FastAdminPanel\Controllers\CrudEntityController;
use App\FastAdminPanel\Controllers\CrudEntityFieldController;
use App\FastAdminPanel\Controllers\DashboardController;
use App\FastAdminPanel\Controllers\DocsController;
use App\FastAdminPanel\Controllers\DropdownController;
use App\FastAdminPanel\Controllers\ExchangeController;
use App\FastAdminPanel\Controllers\ImageController;
use App\FastAdminPanel\Controllers\LanguageController;
use App\FastAdminPanel\Controllers\RoleController;
use App\FastAdminPanel\Controllers\RolePermissionController;
use App\FastAdminPanel\Controllers\SingleController;
use App\FastAdminPanel\Controllers\SingleValueController;
use App\FastAdminPanel\Controllers\SpaController;
use App\FastAdminPanel\Facades\Lang;
use UniSharp\LaravelFilemanager\Lfm;

Route::group([
	'prefix' => Lang::prefix(prefix: 'admin/api'),
], function() {

	Route::get('/ping', [AuthController::class, 'ping'])->name('admin-api-ping');
	Route::post('/sign-in', [AuthController::class, 'signIn'])->name('admin-api-sign-in');
	Route::any('/sign-out', [AuthController::class, 'signOut'])->name('admin-api-sign-out');

	Route::group([
		'middleware' => 'can:everything',
	], function() {

		Route::put('/roles/permissions', [RolePermissionController::class, 'update'])->name('admin-api-roles-permissions-update');

		Route::put('/dropdowns', [DropdownController::class, 'update'])->name('admin-api-dropdowns-update');

		Route::post('/languages', [LanguageController::class, 'store'])->name('admin-api-languages-store');
		Route::put('/languages/{language}', [LanguageController::class, 'update'])->name('admin-api-languages-update');
		Route::delete('/language/{language}', [LanguageController::class, 'destroy'])->name('admin-api-languages-destroy');

		Route::get('/singles', [SingleController::class, 'index'])->name('admin-api-singles-index');
		Route::put('/singles', [SingleController::class, 'update'])->name('admin-api-singles-update');
		Route::delete('/singles', [SingleController::class, 'destroy'])->name('admin-api-singles-destroy');

		Route::post('/cruds', [CrudController::class, 'store'])->name('admin-api-cruds-store');
		Route::put('/cruds/{table}', [CrudController::class, 'update'])->name('admin-api-cruds-update');
		Route::delete('/cruds/{table}', [CrudController::class, 'destroy'])->name('admin-api-cruds-destroy');
	});

	Route::group([
		'middleware' => 'can:show-adminpanel',
	], function() {

		Route::get('/roles', [RoleController::class, 'index'])->name('admin-api-roles-index');
		Route::get('/roles/permissions', [RolePermissionController::class, 'index'])->name('admin-api-roles-permissions-index');
		Route::get('/languages', [LanguageController::class, 'index'])->name('admin-api-languages-index');
		Route::get('/dropdowns', [DropdownController::class, 'index'])->name('admin-api-dropdowns-index');
		Route::get('/cruds', [CrudController::class, 'index'])->name('admin-api-cruds-index');

		// it is unsafe to save images from every admin
		Route::post('/image', [ImageController::class, 'store'])->name('admin-api-image-store');

		Route::get('/singles/values', [SingleValueController::class, 'index'])->name('admin-api-singles-values-index');
		Route::get('/singles/{single_page}/values', [SingleValueController::class, 'show'])->name('admin-api-singles-values-show');
		Route::put('/singles/{single_page}/values', [SingleValueController::class, 'update'])->name('admin-api-singles-values-update');

		Route::get('/cruds/{table}/entities', [CrudEntityController::class, 'index'])->name('admin-api-cruds-entities-index');
		Route::get('/cruds/{table}/entities/{entity_id}', [CrudEntityController::class, 'show'])->name('admin-api-cruds-entities-show');
		Route::put('/cruds/{table}/entities/{entity_id}', [CrudEntityController::class, 'insertOrUpdate'])->name('admin-api-cruds-entities-insert-or-update');
		Route::post('/cruds/{table}/entities/{entity_id}/copy', [CrudEntityController::class, 'copy'])->name('admin-api-cruds-entities-copy');
		Route::delete('/cruds/{table}/entities/{entity_id}', [CrudEntityController::class, 'destroy'])->name('admin-api-cruds-entities-destroy');
		Route::delete('/cruds/{table}/entities', [CrudEntityController::class, 'bulkDestroy'])->name('admin-api-cruds-entities-bulk-destroy');

		Route::put('/cruds/{table}/entities/{entity_id}/fields/{field_id}', [CrudEntityFieldController::class, 'update'])->name('admin-api-cruds-entities-fields-update');

		Route::get('/export/{table}', [ExchangeController::class, 'export'])->name('admin-api-export');
		Route::post('/import/{table}', [ExchangeController::class, 'import'])->name('admin-api-import');

		Route::get('/docs', [DocsController::class, 'index'])->name('admin-api-docs-index');

		Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin-api-dashboard-index');
	});
});

Route::group([
	'middleware' => 'can:show-adminpanel',
	'prefix' => Lang::prefix(),
], function() {

	Route::group(['prefix' => 'laravel-filemanager'], function() {
		Lfm::routes();
	});
});

Route::group([
	'prefix' => Lang::prefix(),
], function() {

	Route::get('/admin', [SpaController::class, 'spa']);
	Route::get('/admin/{any}', [SpaController::class, 'spa'])->where('any', '.*');
});

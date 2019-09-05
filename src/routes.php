<?php

Route::group([
    'namespace'     => 'Digiants\FastAdminPanel\Controllers',
    'middleware'    => 'web'
], function() {

    Route::post('sign-in', 'FAPController@sign_in');
    Route::get('login', 'FAPController@login');
    
    Route::group([
        'middleware'    => [\Digiants\FastAdminPanel\Middleware\AdminOnly::class],
    ], function() {
    
        Route::get('admin', 'FAPController@admin');
        Route::get('admin/dev', 'FAPController@admin');

        Route::post('admin/db-select', 'ApiController@db_select');
        Route::post('admin/db-create-table', 'ApiController@db_create_table');
        Route::post('admin/db-remove-table', 'ApiController@db_remove_table');
        Route::post('admin/db-update-table', 'ApiController@db_update_table');
        Route::post('admin/db-insert-or-update-row', 'ApiController@db_insert_or_update_row');
        Route::post('admin/db-remove-row', 'ApiController@db_remove_row');
        Route::post('admin/db-remove-rows', 'ApiController@db_remove_rows');
        Route::post('admin/db-relationship', 'ApiController@db_relationship');

        Route::post('admin/upload-image', 'ApiController@upload_image');
        Route::post('admin/update-languages', 'ApiController@update_languages');
        
    });
});
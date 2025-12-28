<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Path
    |--------------------------------------------------------------------------
    |
    | This option define url for the admin panel. It doesnt work for now
    |
    */

    'panel_url' => 'admin',	// TODO

    /*
    |--------------------------------------------------------------------------
    | Hidden menu query parameter
    |--------------------------------------------------------------------------
    |
    | This option define query parameter for the showing hidden dev menu
    |
    */

    'hidden_menu_query' => 'dev',

    /*
    |--------------------------------------------------------------------------
    | Migrations mode parameter
    |--------------------------------------------------------------------------
    |
    | This option determines how the admin panel handles migrations.
    | "dev":
    | 	1) if you delete CRUD - old migration will be DELETED
    | 	2) if you update CRUD - old migration will be OVERWRITTEN
    | "prod":
    | 	1) if you delete CRUD - new migration will be ADDED
    | 	2) if you update CRUD - new migration will be ADDED
    |
    */

    'migrations_mode' => 'dev',

    /*
    |--------------------------------------------------------------------------
    | Relationship AJAX threshold
    |--------------------------------------------------------------------------
    |
    | This option defines the threshold for using AJAX in relationship fields in the admin panel.
    | If the number of related records exceeds this threshold, AJAX will be used to load the options.
    |
    */

    'relationship_ajax_threshold' => 200,
];

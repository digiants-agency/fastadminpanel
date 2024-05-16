<?php

use App\FastAdminPanel\Controllers\ApiController;
use App\FastAdminPanel\Controllers\SingleController;
use App\FastAdminPanel\Models\Menu;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| FastAdminPanel API Routes
|--------------------------------------------------------------------------
|
| Here is generated API routes for your fastadminpanel application. These routes 
| were generated automatically using the data you entered in the admin panel.
| Enjoy building your API!
|
*/
    
// $menu = Menu::get();

// foreach ($menu as $menuItem) {

//     Route::group([
// 		'prefix' => Lang::prefix(),
// 	], function() use ($menuItem) {

//         Route::get($menuItem->table_name, [ApiController::class, 'index'])
//         ->defaults('menu_item', $menuItem)
//         ->name('api-index-'.$menuItem->table_name);

//         Route::get($menuItem->table_name.'/{id}', [ApiController::class, 'show'])
//         ->defaults('menu_item', $menuItem)
//         ->name('api-show-'.$menuItem->table_name);
        
//     });
    
//     Route::post($menuItem->table_name, [ApiController::class, 'store'])
//     ->defaults('menu_item', $menuItem)
//     ->name('api-store-'.$menuItem->table_name);

//     Route::put($menuItem->table_name.'/{id}', [ApiController::class, 'update'])
//     ->defaults('menu_item', $menuItem)
//     ->name('api-update-'.$menuItem->table_name);

//     Route::delete($menuItem->table_name.'/{id}',[ApiController::class, 'destroy'])
//     ->defaults('menu_item', $menuItem)
//     ->name('api-destroy-'.$menuItem->table_name);	
// }

Route::group([
    'prefix' => Lang::prefix(),
], function() {

    Route::get('/single/{slug}', [SingleController::class, 'first']);
});

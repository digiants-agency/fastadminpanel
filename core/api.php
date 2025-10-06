<?php

use App\FastAdminPanel\Controllers\ApiController;
use App\FastAdminPanel\Controllers\SingleValueApiController;
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

Route::get('/singles/{slug}', [SingleValueApiController::class, 'show']);

Route::get('/{slug}', [ApiController::class, 'index'])->name('fapi-index');
Route::get('/{slug}/{id}', [ApiController::class, 'show'])->name('fapi-show');
Route::post('/{slug}', [ApiController::class, 'store'])->name('fapi-store');
Route::put('/{slug}/{id}', [ApiController::class, 'update'])->name('fapi-update');
Route::delete('/{slug}/{id}', [ApiController::class, 'destroy'])->name('fapi-destroy');

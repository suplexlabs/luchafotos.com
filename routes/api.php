<?php

use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\TagsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('search.')
    ->prefix('search')
    ->controller(SearchController::class)
    ->group(function () {
        Route::post('/', 'index')->name('index');
    });

Route::name('tags.')
    ->prefix('tags')
    ->controller(TagsController::class)
    ->group(function () {
        Route::get('/similar', 'similar')->name('similar');
    });

Route::middleware('auth:sanctum')
    ->group(function () {
    });

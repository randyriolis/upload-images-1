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

Route::view('/', 'welcome');

Auth::routes();

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth']], function () {
    Route::redirect('/', '/dashboard/categories');
    Route::apiResource('categories', 'CategoryController')->except(['update']);
    Route::get('albums/categories', 'AlbumController@getByCategoryId')->name('albums.category');
    Route::apiResource('albums', 'AlbumController')->except(['update']);
    Route::post('images/regenerate/{albumId}', 'ImageController@regenerate')->name('images.regenerate');
    Route::apiResource('images', 'ImageController')->except(['update', 'show']);
});

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

Auth::routes(['register' => false]);

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth']], function () {
    Route::redirect('/', '/dashboard/folders');
    Route::apiResource('categories', 'CategoryController')->except(['update']);
    Route::get('albums/categories', 'AlbumController@getByCategoryId')->name('albums.category');
    Route::apiResource('albums', 'AlbumController')->except(['update']);
    Route::post('images/regenerate/{albumId}', 'ImageController@regenerate')->name('images.regenerate');
    Route::post('images/path', 'ImageController@storeByPath');
    Route::apiResource('images', 'ImageController')->except(['update', 'show']);
    Route::apiResource('folders', 'FolderController')->except(['update', 'show']);

    Route::group(['prefix' => 'regenerate', 'as' => 'regenerate.'], function () {
        Route::post('all', 'RegenerateController@all')->name('all');
        
        Route::get('category', 'RegenerateController@category')->name('category');
        Route::post('category', 'RegenerateController@categoryPost')->name('categoryPost');

        Route::get('album', 'RegenerateController@album')->name('album');
        Route::post('album', 'RegenerateController@albumPost')->name('albumPost');
    });
});

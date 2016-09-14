<?php

use Illuminate\Http\Request;

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

Route::resource('site-config','ApiSiteConfigController');
Route::put('/site-config', 'ApiSiteConfigController@update');
Route::resource('/artist-type', 'ApiArtistTypeController');
Route::resource('/music-category', 'ApiMusicCategoryController');
Route::resource('/gallery', 'ApiGalleryController');
Route::group(['prefix' => 'image'], function () {
    Route::get('preview/{artist_id}', 'FrontEnd\ImageController@getImagePreview');
});


<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


/*
|--------------------------------------------------------------------------
| Web Route for admin
|--------------------------------------------------------------------------
|
*/
Route::get('quan-tri', ['as' => 'main', 'uses' =>'MainController@index']);
Route::group(['prefix' => 'quan-tri'], function () {
    Route::get('dang-nhap', ['as' => 'auth.login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('dang-nhap', ['as' => 'auth.login', 'uses' => 'Auth\LoginController@login']);
    Route::get('dang-xuat', ['as' => 'auth.logout', 'uses' => 'Auth\LoginController@logout']);
    Route::get('dashboard', ['as' => 'dashboard', 'uses' =>'MainController@index']);
    Route::get('kieu-nghe-si', 'ArtistTypeController@index');
    Route::get('the-loai-nhac', 'MusicCategoryController@index');
    Route::get('cau-hinh', ['as' => 'config', 'uses' =>'SiteConfigController@index']);
    Route::group(['prefix' => 'cau-hinh'], function () {
        Route::get('vi-tri', ['as' => 'config.location', 'uses' =>'SiteConfigController@location']);
        Route::get('thong-tin-cong-ty', ['as' => 'config.company', 'uses' =>'SiteConfigController@company']);
        Route::get('cau-hinh-chung', ['as' => 'config.index', 'uses' =>'SiteConfigController@index']);
    });
    Route::get('su-kien', ['as' => 'gallery', 'uses' =>'GalleryController@index']);
    Route::post('su-kien', ['as' => 'gallery.upload', 'uses' =>'GalleryController@upload']);
    Route::delete('su-kien/{id}', ['as' => 'gallery.delete', 'uses' =>'GalleryController@delete']);

    Route::get('goby-team', ['as' => 'team', 'uses' =>'TeamController@index']);
    Route::post('goby-team', ['as' => 'team', 'uses' =>'TeamController@create']);
    Route::put('goby-team/{team_id}', ['as' => 'team.update', 'uses' =>'TeamController@update']);

    Route::delete('goby-team/{team_id}', ['as' => 'team.update', 'uses' =>'TeamController@delete']);
    Route::get('goby-team/new', ['as' => 'team.new', 'uses' =>'TeamController@detailNew']);
    Route::get('goby-team/edit/{team_id}', ['as' => 'team.edit', 'uses' =>'TeamController@detailEdit']);
    Route::get('artist', ['as' => 'artist', 'uses' =>'ArtistController@index']);
    Route::get('artist/new', ['as' => 'artist.new', 'uses' =>'ArtistController@detailNew']);
    Route::get('artist/edit/{artist_id}', ['as' => 'artist.edit', 'uses' =>'ArtistController@detailEdit']);
    Route::post('artist', ['as' => 'artist.create', 'uses' =>'ArtistController@create']);
    Route::put('artist/{artist_id}', ['as' => 'team.update', 'uses' =>'ArtistController@update']);
    Route::post('artist/upload', ['as' => 'artist.upload', 'uses' =>'ArtistController@upload']);
});

/*
|--------------------------------------------------------------------------
| Web Route for front end
|--------------------------------------------------------------------------
|
|
*/
Route::get('', 'FrontEnd\HomeController@index');
Route::get('trang-chu', 'FrontEnd\HomeController@index');
Route::get('nghe-si/{slug}', 'FrontEnd\ArtistController@detail');
Route::get('gioi-thieu', 'FrontEnd\AboutController@index');
Route::get('lien-he',  ['as' => 'lien-he', 'uses' => 'FrontEnd\ContactController@index']);
Route::post('lien-he','FrontEnd\ContactController@create');
Route::get('danh-sach-nghe-si/{category}/{letter}', 'FrontEnd\ArtistController@index');
Route::get('quan-tam',  ['as' => 'quan-tam', 'uses' => 'FrontEnd\WishListController@index']);
Route::post('quan-tam', ['as' => 'quan-tam.create', 'uses' => 'FrontEnd\WishListController@create']);
Route::post('cart', 'FrontEnd\WishListController@add');
Route::delete('cart/{artist_id}', 'FrontEnd\WishListController@remove');




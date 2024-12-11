<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//User routes
Route::get('/configuracion', 'UserController@config')->name('config');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');

//Movie routes
Route::get('/movie/index', 'MovieController@index')->name('movie.index');
Route::get('/movie/details', 'MovieController@details')->name('movie.details');
Route::get('/movie/create', 'MovieController@create')->name('movie.create');
Route::post('/movie/store', 'MovieController@store')->name('movie.store');

//Genre routes
Route::get('/genre/create', 'GenreController@create')->name('genre.create');
Route::post('/genre/store', 'GenreController@store')->name('genre.store');

//Recomendation routes
Route::get('/recommendation/index', 'RecommendationController@index')->name('recommendation.index');
Route::get('/recommendation/addpending', 'RecommendationController@addpending')->name('recommendation.addpending');
Route::get('/recommendation/removepending', 'RecommendationController@removepending')->name('recommendation.removepending');
Route::get('/recommendation/listpendings', 'RecommendationController@listPendings')->name('recommendation.listpendings');

//Review routes
Route::post('/review/store', 'ReviewController@store')->name('review.store');
Route::delete('/review/{review_id}/delete', 'ReviewController@delete')->name('review.delete');

//ReviewLikes routes
Route::post('/review/like/{review_id}', 'ReviewLikesController@like')->name('review.like');
Route::post('/review/dislike/{review_id}', 'ReviewLikesController@dislike')->name('review.dislike');

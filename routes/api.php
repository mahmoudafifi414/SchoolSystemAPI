<?php

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
Route::post('/register', 'UserController@create');
Route::post('/login', 'UserController@login');
Route::post('/user-details', 'UserController@getUserDetails');
Route::get('/users', 'UserController@getUsersOfSameNetwork');
//posts routes
Route::get('/posts', 'PostsController@getRelatedPosts');
Route::post('/post/add', 'PostsController@storePost');
Route::delete('/post/delete/{id}', 'PostsController@deleteRelatedPost');

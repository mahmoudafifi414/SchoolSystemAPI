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

//Educational Levels Routes

Route::get('/education-level', 'EducationalLevelController@index');
Route::post('/education-level', 'EducationalLevelController@create');
Route::delete('/education-level/{id}', 'EducationalLevelController@delete');

//Subjects Routes

Route::get('/subject', 'SubjectController@index');
Route::post('/subject', 'SubjectController@create');
Route::delete('/subject/{id}', 'SubjectController@delete');
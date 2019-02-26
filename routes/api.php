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
Route::get('/users/{numberPerPage?}', 'UserController@getUsersOfSameNetwork');
Route::get('/user/prepare-data', 'UserController@prepareDataToAddOrEditUser');
Route::get('/user/edit/{id}', 'UserController@edit');
//posts routes
Route::get('/posts', 'PostsController@getRelatedPosts');
Route::post('/post/add', 'PostsController@storePost');
Route::delete('/post/delete/{id}', 'PostsController@deleteRelatedPost');

//Educational Levels Routes

Route::get('/education-level', 'EducationalLevelController@index');
Route::post('/education-level', 'EducationalLevelController@create');
Route::delete('/education-level/{id}', 'EducationalLevelController@delete');

//Subjects Routes

Route::get('/subject', 'SubjectsController@index');
Route::post('/subject', 'SubjectsController@create');
Route::delete('/subject/{id}', 'SubjectsController@delete');

//semester Routes

Route::get('/semester', 'SemesterController@index');
Route::post('/semester', 'SemesterController@create');

//academic year Routes
Route::get('/year', 'YearController@index');
Route::post('/year', 'YearController@create');
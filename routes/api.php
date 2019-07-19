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
Route::post('/user', 'UserController@store');
//teacher routes
Route::get('/teacher', 'TeacherController@getAllTeachers');
//posts routes
Route::get('/posts', 'PostsController@getRelatedPosts');
Route::post('/post/add', 'PostsController@storePost');
Route::delete('/post/delete/{id}', 'PostsController@deleteRelatedPost');

//Educational Levels Routes

Route::get('/education-level', 'EducationalLevelController@index');
Route::post('/education-level', 'EducationalLevelController@create');
Route::delete('/education-level/{id}', 'EducationalLevelController@delete');


//semester Routes

Route::get('/semester', 'SemesterController@index');
Route::post('/semester', 'SemesterController@create');

//academic year Routes
Route::get('/year/{numberPerPage?}', 'YearController@index');
Route::post('/year', 'YearController@create');
Route::get('/year/get-relations-data/{id}', 'YearController@getRelationsData');
Route::post('/year/attach-classroom', 'YearController@attachClassroom');
Route::post('/year/detach-classroom', 'YearController@detachClassroom');
Route::post('/year/attach-semester', 'YearController@attachSemester');
Route::post('/year/detach-semester', 'YearController@detachSemester');

//classrooms routes
route::get('/classroom/{numberPerPage?}', 'ClassroomController@index');
route::get('/classroom/get-related-years/{classroomId}', 'ClassroomController@getRelatedYears');
route::get('/classroom/get-related-semesters/{classroomId}', 'ClassroomController@getRelatedSemesters');
route::get('/classroom/get-related-subjects/{classroomId}/{yearId}', 'ClassroomController@getRelatedSubjects');
route::post('/classroom/get-display-option-data', 'ClassroomController@getDisplayOptionData');
Route::get('/classroom/get-relations-data/{id}', 'ClassroomController@getRelationsData');
route::post('/classroom/attachSubjectToSemester', 'ClassroomController@attachSubjectToSemester');
route::post('/classroom/detachSubjectToSemester', 'ClassroomController@detachSubjectToSemester');
route::post('/classroom/detach-teacher-from-classroom', 'ClassroomController@detachTeacherFromClassroom');
route::post('/classroom/available-subjects-with-teachers', 'ClassroomController@availableSubjectsWithTeachers');
//semesters routes
route::get('/semester/{numberPerPage?}', 'SemesterController@index');

//Subjects Routes
Route::get('/subject/get-relations-data/{id}', 'SubjectController@getRelationsData');
route::get('/subject/{numbnerPerPage?}', 'SubjectController@index');
route::post('/subject', 'SubjectController@create');
route::get('/subject/getRelatedTeachers/{subjectId}', 'SubjectController@getRelatedTeachers');
route::post('/subject/applyTeachersToSubject/{subjectId}', 'SubjectController@applyTeachersToSubject');
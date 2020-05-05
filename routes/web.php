<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::get('/profile/changename', 'ProfileController@changeName')->name('changeName');
Route::post('/profile/changename', 'ProfileController@saveName')->name('saveName');

Route::get('/courses', 'CoursesController@userCourses')->name('userCourses');
Route::get('/create-course', 'CoursesController@createCourse')->name('createCourse');
Route::post('/create-course', 'CoursesController@saveCourse')->name('saveCourse');
Route::get('/courses/{id}/update', 'CoursesController@updateCourse')->name('updateCourse');
Route::post('/courses/{id}/update', 'CoursesController@saveUpdatedCourse')->name('saveUpdatedCourse');
Route::get('/courses/{id}/delete', 'CoursesController@deleteCourse')->name('deleteCourse');
Route::get('/course/{id}', 'CoursesController@courseInfo')->name('courseInfo');
Route::get('/course/{id}/subscribe', 'CoursesController@subscribe')->name('subscribe');
Route::get('/courses/{id}/unsubscribe', 'CoursesController@unsubscribe')->name('unsubscribe');
Route::get('/courses/{id}/publish', 'CoursesController@publishCourse')->name('publishCourse');
Route::get('/courses/{id}/unpublish', 'CoursesController@unpublishCourse')->name('unpublishCourse');

Route::get('/courses/test/{id}/edit', 'TestsController@editTest')->name('editTest');
Route::post('/courses/test/{id}/edit', 'TestsController@saveQuestion')->name('saveQuestion');
Route::post('/courses/test/{test_id}/question/{questions_id}', 'TestsController@updateQuestion')->name('updateQuestion');
Route::get('/courses/test/{test_id}/question/{questions_id}/delete', 'TestsController@deleteQuestion')->name('deleteQuestion');

Route::get('/courses/test/{id}', 'TestingController@index')->name('testing');
Route::post('/courses/test/{id}', 'TestingController@testingEvaluation')->name('testingEvaluation');
Route::get('/courses/test/{id}/results', 'TestingController@testingResults')->name('testingResults');
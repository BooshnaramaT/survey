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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('addusers','AddusersController');
Route::post('importExcel', 'ImportusersController@importExcel');

Route::get('importQuestion','QuestionsImportController@importQuestion');
Route::post('storeQues', 'QuestionsImportController@stoteQuestions');

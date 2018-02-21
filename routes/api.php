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

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'UserController@getMyInfo');

    Route::post('user/email', 'UserController@editEmail');
    Route::post('user/password', 'UserController@editPassword');

    Route::get('user/schedule/{day}', 'UserController@getSchedule');

    Route::get('user/subjects', 'UserController@getSubjects');

    Route::get('subject/{subjectId}', 'SubjectController@get');

    Route::middleware('permissions')->group(function () {
        Route::post('subject/{subjectId}/message', 'SubjectController@addMessage');
        Route::delete('subject/{subjectId}/message/{messageId}', 'SubjectController@deleteMessage');

        Route::post('subject/{subjectId}/file', 'SubjectController@addFile');
        Route::post('subject/{subjectId}/file/{fileId}', 'SubjectController@editFile');
        Route::delete('subject/{subjectId}/file/{fileId}', 'SubjectController@deleteFile');
    });

    Route::get('subject/{subjectId}/files', 'SubjectController@getFiles');
});
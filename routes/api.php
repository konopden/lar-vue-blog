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

Route::group(['namespace' => 'Api',], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:api');
});



Route::group(['namespace' => 'Api', 'middleware' => ['auth', 'admin']], function () {
    Route::resource('user', 'UserController', ['except' => ['create', 'show']]);
    Route::resource('article', 'ArticleController', ['except' => ['create', 'show']]);
    Route::resource('category', 'CategoryController', ['except' => ['create', 'show']]);
    Route::resource('tag', 'TagController', ['except' => ['create', 'show']]);
    Route::resource('comment', 'CommentController', ['except' => ['create', 'show']]);
    Route::post('/comment/{id}/status', 'CommentController@status');
    Route::get('categories', 'CategoryController@getList');
    Route::get('tags', 'TagController@getList');
    Route::get('visitor', 'VisitorController@index');
    Route::get('system', 'SystemController@index');
    Route::get('files', 'UploadController@index');
    Route::post('folder/create', 'UploadController@createFolder');
    Route::post('files/upload', 'UploadController@uploadFile');
    Route::post('folder/delete', 'UploadController@deleteFolder');
    Route::post('file/delete', 'UploadController@deleteFile');
    Route::post('files/rename', 'UploadController@rename');
});

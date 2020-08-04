<?php
Route::get('/', function () {
    return redirect(app()->getLocale());
});

Route::get('statistics', 'AdminController@statistics')->middleware('auth', 'admin');

// Comment
Route::get('comments/{articleId}/show', 'CommentController@show');
Route::post('comments/{articleId}/add', 'CommentController@add');

// File Upload
Route::post('file/upload', 'UploadController@fileUpload');

// Edit Avatar
Route::post('crop/avatar', 'UserController@cropAvatar');

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => 'en|ru'],
    'middleware' => 'setlocale'
], function () {
// User Auth
    Auth::routes();

// User
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index');

        Route::group(['middleware' => 'auth'], function () {
            Route::get('profile', 'UserController@edit');
            Route::put('profile/{id}', 'UserController@update');
        });

        Route::group(['prefix' => '{id}'], function () {
            Route::get('/', 'UserController@show');
        });
    });

// Admin Panel
    Route::group(['prefix' => 'admin-panel', 'middleware' => ['auth', 'admin']], function () {
        Route::get('{path?}', 'AdminController@index')->where('path', '[\/\w\.-]*');
    });

// About
    Route::get('about', 'AboutController@index');

// Contact
    Route::get('contact', 'ContactController@index');
    Route::post('feedback/add', 'ContactController@add');

// Tag
    Route::get('tag', 'TagController@index');
    Route::get('tag/{tag}', 'ArticleController@searchByTag');

// Article
    Route::get('/', 'ArticleController@index');
    Route::get('{category}', 'ArticleController@indexCategory')->name('category');
    Route::get('{category}/{slug}', 'ArticleController@show')->name('article');

// Search
    Route::post('search/{search}', 'SearchController@search');

// Subscribe
    Route::post('subscribe/add', 'SubscriberController@add');

});

<?php

use Illuminate\Support\Facades\Route;
use LambdaDigamma\MMFeeds\Http\Controllers\API\FeedController;
use LambdaDigamma\MMFeeds\Http\Controllers\API\FeedPostsController;
use LambdaDigamma\MMFeeds\Http\Controllers\API\PostController;

Route::group([
    'prefix' => 'v1/',
    'as' => 'v1.'
], function () {

    Route::get('/feeds/{id}', [FeedController::class, 'show'])
        ->middleware('cache.headers:public;max_age=300;etag')
        ->name('feeds.show');

    Route::get('/feeds/{id}/posts', [FeedPostsController::class, 'index'])
        ->middleware('cache.headers:public;max_age=300;etag')
        ->name('feeds.posts.index');

    Route::get('/posts/{id}', [PostController::class, 'show'])
        ->middleware('cache.headers:public;max_age=300;etag')
        ->name('posts.show');

});

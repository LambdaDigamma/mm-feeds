<?php

use Illuminate\Support\Facades\Route;
use LambdaDigamma\MMFeeds\Http\Controllers\API\FeedController;
use LambdaDigamma\MMFeeds\Http\Controllers\API\FeedPostsController;

Route::group([
    'prefix' => 'v1/',
    'as' => 'v1.'
], function () {
    
    Route::apiResource('feeds', FeedController::class)->except(['index', 'store', 'update', 'destroy']);
    Route::apiResource('feeds.posts', FeedPostsController::class)->except([]);


});
<?php

use Illuminate\Support\Facades\Route;
use LambdaDigamma\MMFeeds\Http\Controllers\Admin\PostController;
use LambdaDigamma\MMFeeds\Http\Controllers\Admin\PublishedPostsController;

/**
 * Posts
 */

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

Route::post('/posts/{anypost}/publish', [PublishedPostsController::class, 'publish'])->name('posts.publish');
Route::post('/posts/{anypost}/unpublish', [PublishedPostsController::class, 'unpublish'])->name('posts.unpublish');

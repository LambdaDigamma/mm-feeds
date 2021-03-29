<?php

namespace LambdaDigamma\MMFeeds\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use LambdaDigamma\MMFeeds\Http\Controllers\Controller;
use LambdaDigamma\MMFeeds\Http\Requests\StorePostRequest;
use LambdaDigamma\MMFeeds\Models\Post;

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->validated());

        return $request->wantsJson()
                ? new JsonResponse($post, 302)
                : back()->with('success', 'Der Post wurde erstellt.')->with('data', ['id' => $post->id]);
    }
}
<?php

namespace LambdaDigamma\MMFeeds\Http\Controllers\API;

use LambdaDigamma\MMFeeds\Models\Post;

class PostController
{
    public function show($id)
    {
        /** @var Post $post */
        $post = config('mm-feeds.post_model')::query()
            ->where('id', $id)
            ->with('media')
            ->firstOrFail();

        if ($post->isPublished()) {
            return response()->json([
                'data' => $post,
            ]);
        } else {
            return response()->json([
                'data' => null,
            ], 404);
        }
    }
}

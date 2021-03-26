<?php


namespace LambdaDigamma\MMFeeds\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LambdaDigamma\MMFeeds\Http\Controllers\Controller;
use LambdaDigamma\MMFeeds\Http\Requests\PublishPost;
use LambdaDigamma\MMFeeds\Models\Post;

class PublishedPostsController extends Controller
{
    public function publish(PublishPost $request, Post $post)
    {
        $published_at = $request->get('published_at', now());

        $post->published_at = $published_at;
        $post->save();

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Post wurde veröffentlicht.');
    }

    public function unpublish(Request $request, Post $post)
    {
        $post->unpublish();

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Post wurde ins Entwurfsstadium zurückversetzt.');
    }
}

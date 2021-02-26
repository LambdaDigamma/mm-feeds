<?php


namespace LambdaDigamma\MMFeeds\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LambdaDigamma\MMFeeds\Http\Controllers\Controller;
use LambdaDigamma\MMFeeds\Models\Post;

class PublishedPostsController extends Controller
{
    public function publish(Request $request, Post $post)
    {
//        $post->publish();

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

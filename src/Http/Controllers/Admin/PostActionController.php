<?php

namespace LambdaDigamma\MMFeeds\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LambdaDigamma\MMFeeds\Http\Controllers\Controller;
use LambdaDigamma\MMFeeds\Models\Post;

class PostActionController extends Controller
{
    public function archive(Request $request, Post $post)
    {
        $post->archive();

        return $request->wantsJson()
                ? new JsonResponse('', 200)
                : redirect()->back()->with('success', 'Der Post wurde archiviert.');
    }

    public function unarchive(Request $request, Post $post)
    {
        $post->unArchive();

        return $request->wantsJson()
                ? new JsonResponse('', 200)
                : redirect()->back()->with('success', 'Das Archivieren wurde rückgängig gemacht.');
    }
}

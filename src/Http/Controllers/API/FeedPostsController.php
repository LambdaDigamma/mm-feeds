<?php

namespace LambdaDigamma\MMFeeds\Http\Controllers\API;

use LambdaDigamma\MMFeeds\Http\Controllers\Controller;
use LambdaDigamma\MMFeeds\Http\Resources\PostCollection;

class FeedPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\LambdaDigamma\MMFeeds\Http\Resources\PostCollection
     */
    public function index($id)
    {
        $feedModel = config('mm-feeds.feed_model');

        return new PostCollection(
            $feedModel::findOrFail($id)
            ->posts()
            ->with(['media'])
            ->chronological()
            ->jsonPaginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return new EventResource(Event::with('page', 'place')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace LambdaDigamma\MMFeeds\Http\Controllers\API;

use Illuminate\Http\Request;
use LambdaDigamma\MMFeeds\Http\Controllers\Controller;
use LambdaDigamma\MMFeeds\Http\Resources\Feed as FeedResource;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(): void
    {
        // return new EventCollection(Event::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int  $id
     *
     * @return FeedResource
     */
    public function show($id): FeedResource
    {
        config('json-api-paginate.default_size');
        $sizeParameter = config('json-api-paginate.size_parameter');
        $paginationParameter = config('json-api-paginate.pagination_parameter');

        $size = (int) request()->input($paginationParameter.'.'.$sizeParameter, 10);

        $feedModel = config('mm-feeds.feed_model');

        return new FeedResource(
            $feedModel::with([
                'posts' => function ($query) {
                    $query
                        ->with(['media'])
                        ->chronological()
                        ->jsonPaginate(10);
                },
            ])
            ->findOrFail($id)
        );

        // return new EventResource(Event::with('page', 'place')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param int  $id
     *
     * @return void
     */
    public function update(Request $request, $id): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $id
     *
     * @return void
     */
    public function destroy($id): void
    {
        //
    }
}

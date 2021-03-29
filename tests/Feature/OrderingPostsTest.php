<?php

use LambdaDigamma\MMFeeds\Models\Feed;
use LambdaDigamma\MMFeeds\Models\Post;

test('posts belonging to feed have publication pivot with order column', function () {
    $feed = Feed::factory()->create();
    $posts = Post::factory()->count(5)->published()->create();

    $map = collect([
        null => $posts[4],
        '0' => $posts[3],
        '1' => $posts[1],
        '3' => $posts[0],
        '4' => $posts[2],
    ]);

    $map->each(function ($post, $key) use ($feed) {
        $feed->posts()->attach($post, ['order' => $key]);
    });

    $orderArray = Feed::find($feed->id)
        ->posts
        ->pluck('id')
        ->all();

    expect($orderArray)
        ->toBeArray()
        ->and($orderArray)
        ->toBe([4, 2, 1, 3, 5]);
});

<?php

use LambdaDigamma\MMFeeds\Models\Feed;
use LambdaDigamma\MMFeeds\Models\Post;

test('posts belonging to feed have publication pivot with order column', function () {
    $feed = Feed::factory()->create();
    $posts = Post::factory()->count(5)->create();

    $map = collect([
        '3' => $posts[0],
        '1' => $posts[1],
        '4' => $posts[2],
        '0' => $posts[3],
        '2' => $posts[4],
    ]);

    $map->each(function ($post, $key) use ($feed) {
        $feed->posts()->attach($post, ['order' => $key]);
    });

    $orderArray = Feed::find($feed->id)
        ->posts
        ->map(fn ($post) => $post->publication)
        ->pluck('order')
        ->all();

    expect($orderArray)
        ->toBeArray()
        ->and($orderArray)
        ->toBe(['0', '1', '2', '3', '4']);
});

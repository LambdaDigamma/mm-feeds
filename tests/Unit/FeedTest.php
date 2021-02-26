<?php

use LambdaDigamma\MMFeeds\Models\Feed;
use LambdaDigamma\MMFeeds\Models\Post;

test('feed can be created', function () {
    $feed = Feed::factory()->create([
        'name' => 'Main Feed',
    ]);

    expect($feed->name)->toBe('Main Feed');
});

test('feed can have localized name', function () {
    app()->setLocale('en');

    $feed = Feed::factory()->create([
        'name' => 'Main Feed',
    ]);

    $feed->setTranslation('name', 'de', 'Hauptfeed');

    expect($feed->getTranslation('name', 'en'))->toBe('Main Feed');
    expect($feed->getTranslation('name', 'de'))->toBe('Hauptfeed');
});

test('add post to feed', function () {
    $feed = Feed::factory()->create();
    $post = Post::factory()->make();

    $feed->posts()->save($post);

    expect($feed->posts)->toHaveCount(1);
});

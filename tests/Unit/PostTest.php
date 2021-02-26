<?php

use LambdaDigamma\MMFeeds\Models\Feed;
use LambdaDigamma\MMFeeds\Models\Post;

test('post can be created', function () {

    $post = Post::factory()->create([
        'title' => 'Post #1',
        'summary' => 'This is a short summary.',
        'slug' => 'post-1',
    ]);

    expect($post->title)->toBe('Post #1')
        ->and($post->summary)->toBe('This is a short summary.')
        ->and($post->slug)->toBe('post-1');

});

test('post can have localized title, summary, slug', function () {

    app()->setLocale('en');

    $post = Post::factory()->create([
        'title' => 'Post #1',
        'summary' => 'Short summary',
        'slug' => 'post-1',
    ]);

    $post->setTranslation('title', 'de', 'Eintrag #1');
    $post->setTranslation('summary', 'de', 'Kurze Zusammenfassung');
    $post->setTranslation('slug', 'de', 'eintrag-1');

    expect($post->getTranslation('title', 'en'))->toBe('Post #1')
        ->and($post->getTranslation('title', 'de'))->toBe('Eintrag #1');

    expect($post->getTranslation('summary', 'en'))->toBe('Short summary')
        ->and($post->getTranslation('summary', 'de'))->toBe('Kurze Zusammenfassung');

    expect($post->getTranslation('slug', 'en'))->toBe('post-1')
        ->and($post->getTranslation('slug', 'de'))->toBe('eintrag-1');

});

test('post can belong to feed', function () {

    $post = Post::factory()->create();
    $feed = Feed::factory()->create();

    $feed->posts()->save($post);

    expect($post->feed->id)->toBe($feed->id);

});

test('post can be published', function () {

    $post = Post::factory()->create();

    expect($post->published_at)->toBeNull();

    $post->publish();

    expect($post->published_at)->not->toBeNull();

});

test('post can be unpublished', function () {

    $post = Post::factory()->published()->create();

    expect($post->published_at)->not->toBeNull();

    $post->unpublish();

    expect($post->published_at)->toBeNull();

});

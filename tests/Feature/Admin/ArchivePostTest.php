<?php

use LambdaDigamma\MMFeeds\Models\Post;
use Orchestra\Testbench\Factories\UserFactory;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

test('post can be archived', function () {
    actingAs(UserFactory::new()->create());
    $post = Post::factory()->published()->create();
    expect($post->archived_at)->toBeNull();

    postJson("/admin/posts/{$post->id}/archive")->assertStatus(200);
    expect(Post::query()->withNotPublished()->withArchived()->find($post->id)->archived_at)
        ->not->toBeNull();
});

test('not published post can be archived', function () {
    actingAs(UserFactory::new()->create());
    $post = Post::factory()->create();
    expect($post->archived_at)->toBeNull();

    postJson("/admin/posts/{$post->id}/archive")->assertStatus(200);
    expect(Post::query()->withNotPublished()->withArchived()->find($post->id)->archived_at)
        ->not->toBeNull();
});

test('archived post can be unarchived', function () {
    actingAs(UserFactory::new()->create());
    $post = Post::factory()->published()->archived()->create();
    expect($post->archived_at)->not->toBeNull();

    postJson("/admin/posts/{$post->id}/unarchive")->assertStatus(200);
    expect(Post::query()->withNotPublished()->withArchived()->find($post->id)->archived_at)->toBeNull();
});

test('archived not published post can be unarchived', function () {
    actingAs(UserFactory::new()->create());
    $post = Post::factory()->archived()->create();
    
    expect($post->archived_at)->not->toBeNull();

    postJson("/admin/posts/{$post->id}/unarchive")->assertStatus(200);
    expect(Post::query()->withNotPublished()->withArchived()->find($post->id)->archived_at)->toBeNull();
});

<?php

namespace LambdaDigamma\MMFeeds\Tests\Feature\Admin;

use LambdaDigamma\MMFeeds\Models\Post;
use Orchestra\Testbench\Factories\UserFactory;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;

test('authenticated user can store post via form (POST /admin/posts)', function () {
    
    expect(Post::all())->toHaveCount(0);
    actingAs(UserFactory::new()->create());

    post(route('admin.posts.store'), [
        'title' => 'Title of the post',
        'summary' => 'This is a short summary',
    ])->assertStatus(302);

    $post = Post::withNotPublished()->first();

    expect($post->title)->toBe('Title of the post');
    expect($post->summary)->toBe('This is a short summary');
});

test('store post via json (POST /admin/posts)', function () {
    
    expect(Post::all())->toHaveCount(0);
    actingAs(UserFactory::new()->create());

    postJson(route('admin.posts.store'), [
        'title' => 'Title of the post',
        'summary' => 'This is a short summary',
    ])
    ->assertStatus(302)
    ->assertJson([
        'id' => 1,
        'title' => 'Title of the post',
        'summary' => 'This is a short summary',
    ]);

    $post = Post::withNotPublished()->first();

    expect($post->title)->toBe('Title of the post');
    expect($post->summary)->toBe('This is a short summary');
});

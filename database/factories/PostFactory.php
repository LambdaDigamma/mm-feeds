<?php

namespace LambdaDigamma\MMFeeds\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LambdaDigamma\MMFeeds\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(2, true),
            'summary' => $this->faker->sentences(2, true),
        ];
    }

    public function published()
    {
        return $this->state(fn () => [
            'published_at' => now(),
        ]);
    }

    public function notPublished()
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => null,
            ];
        });
    }

    public function archived()
    {
        return $this->state(function (array $attributes) {
            return [
                'archived_at' => now(),
            ];
        });
    }

    public function notArchived()
    {
        return $this->state(function (array $attributes) {
            return [
                'archived_at' => null,
            ];
        });
    }
}


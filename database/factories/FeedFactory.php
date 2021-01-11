<?php

namespace LambdaDigamma\MMFeeds\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LambdaDigamma\MMFeeds\Models\Feed;

class FeedFactory extends Factory
{
    protected $model = Feed::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
        ];
    }
}


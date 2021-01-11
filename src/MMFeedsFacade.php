<?php

namespace LambdaDigamma\MMFeeds;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LambdaDigamma\MMFeeds\MMFeeds
 */
class MMFeedsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mm-feeds';
    }
}

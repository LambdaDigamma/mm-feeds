<?php

namespace LambdaDigamma\MMFeeds\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Publication extends Pivot
{
    protected $table = "mm_publications";
}

<?php

namespace LambdaDigamma\MMFeeds\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LambdaDigamma\MMFeeds\Database\Factories\PostFactory;
use LambdaDigamma\MMFeeds\Traits\SerializeTranslations;
use LaravelArchivable\Archivable;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;
    use SerializeTranslations;
    use Archivable;

    protected $table = "mm_posts";
    protected $guarded = ['*', 'id'];
    public $translatable = ['title', 'description'];

    public static function newFactory()
    {
        return PostFactory::new();
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class, 'feed_id', 'id');
    }

    /**
     * Orders the query with a chronological published date.
     * Events without a start date go last.
     *
     * @return Builder
     */
    public function scopeChronological(Builder $query)
    {
        return $query
            ->orderByRaw('-published_at DESC');
    }

    /**
     *
     * @return Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query
            ->where('published_at', '!=', null);
    }
}

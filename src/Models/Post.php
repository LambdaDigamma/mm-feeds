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
    public $translatable = ['title', 'summary', 'slug'];

    public static function newFactory()
    {
        return PostFactory::new();
    }

    public function feeds()
    {
        return $this->belongsToMany(Feed::class, 'mm_post_feed', 'feed_id', 'post_id');
    }

    public function publish()
    {
        return $this->update(['published_at' => now()]);
    }

    public function unpublish()
    {
        return $this->update(['published_at' => null]);
    }

    /**
     * Orders the query with a chronological published date.
     * Events without a start date go last.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return Builder
     */
    public function scopeChronological(Builder $query)
    {
        return $query
            ->orderByRaw('-published_at ASC');
    }

    /**
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query
            ->where('published_at', '!=', null);
    }
}

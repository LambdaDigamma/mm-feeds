<?php

namespace LambdaDigamma\MMFeeds\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LambdaDigamma\MMFeeds\Database\Factories\FeedFactory;
use LambdaDigamma\MMFeeds\Traits\SerializeTranslations;

class Feed extends Model
{
    use SoftDeletes;
    use HasFactory;
    use SerializeTranslations;

    protected $table = "mm_feeds";
    protected $guarded = ['*', 'id'];
    public $translatable = ['name', 'extras'];

    public static function newFactory()
    {
        return FeedFactory::new();
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'mm_post_feed', 'feed_id', 'post_id')->chronological();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}

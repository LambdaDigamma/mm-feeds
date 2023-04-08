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

    public static function newFactory(): FeedFactory
    {
        return FeedFactory::new();
    }

    public function posts()
    {
        return $this
            ->belongsToMany(Post::class, 'mm_publications', 'feed_id', 'post_id')
            ->using(Publication::class)
            ->as('publication')
            ->withPivot('order')
            ->withTimestamps()
            ->chronological()
            ->orderByPivot('order');
    }

    public function scopeFilter($query, array $filters): void
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

    public function toArray()
    {
        $attributes = parent::toArray();

//        dd($this->getTranslatableAttributes());
        return $this->serializeTranslations($attributes);

//        dd($attributes);
//
//        return $attributes;
    }
}

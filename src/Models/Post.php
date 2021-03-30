<?php

namespace LambdaDigamma\MMFeeds\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LambdaDigamma\MMFeeds\Database\Factories\PostFactory;
use LambdaDigamma\MMFeeds\Traits\SerializeTranslations;
use LaravelArchivable\Archivable;
use LaravelPublishable\Publishable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory;
    use Archivable;
    use Publishable;
    use SerializeTranslations;
    use InteractsWithMedia;

    protected $table = "mm_posts";
    protected $guarded = ['*', 'id'];
    public $translatable = ['title', 'summary', 'slug', 'external_href'];
    protected $appends = ['cta'];
    protected $casts = [
        'extras' => AsCollection::class,
    ];

    public static function newFactory()
    {
        return PostFactory::new();
    }

    public function feeds()
    {
        return $this
            ->belongsToMany(Feed::class, 'mm_publications', 'post_id', 'feed_id')
            ->as('publication')
            ->using(Publication::class)
            ->orderByPivot('order');
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header')
            ->singleFile()
            ->withResponsiveImages()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('opengraph')
                    ->width(1200)
                    ->height(630);
            });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function getCtaAttribute()
    {
        return $this->extras ? $this->extras->get('cta', 'read') : "read";
    }

    public function setCtaAttribute($value)
    {
        if ($this->extras) {
            $this->extras->set('cta', $value);
        } else {
            $this->extras = collect(['cta' => $value]);
        }
    }
}

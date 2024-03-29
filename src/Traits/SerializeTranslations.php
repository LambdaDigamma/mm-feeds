<?php

namespace LambdaDigamma\MMFeeds\Traits;

use Spatie\Translatable\HasTranslations;

trait SerializeTranslations
{
    use HasTranslations;

    public function toArray()
    {
        $attributes = parent::toArray();

        return $this->serializeTranslations($attributes);
    }

    public function serializeTranslations($attributes = []): array
    {
        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }

        return $attributes;
    }
}

<?php

namespace LambdaDigamma\MMFeeds\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request  $request
     *
     * @return Arrayable|\JsonSerializable|array
     */
    public function toArray($request): array|Arrayable|\JsonSerializable
    {
        return parent::toArray($request);
    }
}

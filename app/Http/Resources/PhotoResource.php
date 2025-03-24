<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id'                       => $this->id,
            'slug'                     => $this->slug,
            'alternative_slugs'        => $this->alternative_slugs,
            'created_at'               => $this->created_at,
            'updated_at'               => $this->updated_at,
            'width'                    => $this->width,
            'height'                   => $this->height,
            'color'                    => $this->color,
            'blur_hash'                => $this->blur_hash,
            'description'              => $this->description,
            'alt_description'          => $this->alt_description,
            'urls'                     => $this->urls,
            'links'                    => $this->links,
            'likes'                    => $this->likes,
            'liked_by_user'            => $this->liked_by_user,
            'current_user_collections' => $this->current_user_collections,
            'sponsorship'              => $this->sponsorship,
            'topic_submissions'        => $this->topic_submissions,
            'asset_type'               => $this->asset_type,
            'user'                     => $this->user,
        ];
    }
}

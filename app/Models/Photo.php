<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected function casts()
    {
        return [
            'id'                       => 'string',
            'alternative_slugs'        => 'json',
            'urls'                     => 'json',
            'links'                    => 'json',
            'current_user_collections' => 'json',
            'sponsorship'              => 'json',
            'topic_submissions'        => 'json',
            'user'                     => 'json',
        ];
    }
}

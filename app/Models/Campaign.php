<?php

namespace App\Models;

use App\Traits\CleansUpMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Campaign extends Model
{
    use HasTranslations, CleansUpMedia;

    protected array $singleMediaFields = ['cover_image', 'og_image'];

    public array $translatable = [
        'title', 'slug', 'short_description', 'content',
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected $fillable = [
        'title', 'slug', 'short_description', 'content',
        'cover_image', 'starts_at', 'ends_at', 'is_active',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];
}

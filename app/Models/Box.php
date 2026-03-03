<?php

namespace App\Models;

use App\Traits\CleansUpMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Box extends Model
{
    use HasTranslations, CleansUpMedia;

    protected array $singleMediaFields = ['cover_image', 'og_image'];

    public array $translatable = [
        'title', 'slug', 'category', 'short_description', 'content',
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected $fillable = [
        'title', 'slug', 'category', 'short_description', 'content',
        'cover_image', 'price', 'order', 'is_active',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price'     => 'decimal:2',
    ];
}

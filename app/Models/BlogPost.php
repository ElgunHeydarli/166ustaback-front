<?php

namespace App\Models;

use App\Traits\CleansUpMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model
{
    use HasTranslations, CleansUpMedia;

    protected array $singleMediaFields = ['cover_image', 'og_image'];

    public array $translatable = [
        'title', 'slug', 'excerpt', 'content',
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content',
        'cover_image', 'is_active', 'published_at',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'published_at' => 'datetime',
    ];

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_blog_tag');
    }
}

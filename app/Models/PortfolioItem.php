<?php

namespace App\Models;

use App\Traits\CleansUpMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PortfolioItem extends Model
{
    use HasTranslations, CleansUpMedia;

    protected array $singleMediaFields = ['cover_image', 'og_image'];
    protected array $arrayMediaFields  = ['gallery'];

    public array $translatable = [
        'title', 'slug', 'short_description', 'content',
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected $fillable = [
        'title', 'slug', 'short_description', 'content',
        'cover_image', 'client', 'duration', 'gallery', 'service_id', 'order', 'is_active',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image',
    ];

    protected $casts = [
        'gallery'   => 'array',
        'is_active' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

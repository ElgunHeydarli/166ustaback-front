<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'subtitle', 'button_text'];

    protected $fillable = [
        'title', 'subtitle', 'image',
        'button_text', 'button_url', 'order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];
}

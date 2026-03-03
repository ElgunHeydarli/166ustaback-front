<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HomeAbout extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'content', 'image1', 'image2', 'button_text', 'button_url'];

    public array $translatable = ['title', 'content', 'button_text'];
}

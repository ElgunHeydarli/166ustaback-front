<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HomeCta extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'description', 'button_text', 'button_url', 'image'];

    public array $translatable = ['title', 'description', 'button_text'];
}

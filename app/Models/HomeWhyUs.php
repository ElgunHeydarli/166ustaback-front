<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HomeWhyUs extends Model
{
    use HasTranslations;

    protected $table = 'home_why_us';

    public array $translatable = ['title', 'subtitle'];

    protected $fillable = ['title', 'subtitle', 'items'];

    protected $casts = ['items' => 'array'];
}

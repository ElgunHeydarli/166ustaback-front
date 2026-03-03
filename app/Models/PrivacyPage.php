<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PrivacyPage extends Model
{
    use HasTranslations;

    public array $translatable = ['content'];

    protected $fillable = ['content'];
}

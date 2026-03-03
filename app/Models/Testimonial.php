<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
{
    use HasTranslations;

    public array $translatable = ['position', 'review_text'];

    protected $fillable = [
        'customer_name', 'position', 'review_text',
        'photo', 'rating', 'service_id', 'order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

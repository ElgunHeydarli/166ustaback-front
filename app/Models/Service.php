<?php

namespace App\Models;

use App\Traits\CleansUpMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasTranslations, CleansUpMedia;

    protected array $singleMediaFields = ['icon', 'image', 'og_image'];
    protected array $arrayMediaFields  = ['images'];

    public array $translatable = [
        'title', 'slug', 'short_description', 'content',
        'steps_title', 'steps_subtitle',
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected $fillable = [
        'title', 'slug', 'short_description', 'content',
        'icon', 'image', 'images',
        'advantages', 'steps_title', 'steps_subtitle', 'steps',
        'order', 'is_active', 'show_in_menu',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'show_in_menu' => 'boolean',
        'images'       => 'array',
        'advantages'   => 'array',
        'steps'        => 'array',
    ];

    public function portfolioItems()
    {
        return $this->hasMany(PortfolioItem::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class);
    }

    // advantages[locale] → array of 4 strings
    public function getAdvantages(string $locale): array
    {
        $adv = $this->advantages ?? [];
        return $adv[$locale] ?? $adv['az'] ?? ['', '', '', ''];
    }

    // steps → array of ['image'=>..., 'title'=>[...], 'description'=>[...]]
    public function getSteps(): array
    {
        return $this->steps ?? [];
    }
}

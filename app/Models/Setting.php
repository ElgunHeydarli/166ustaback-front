<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    // Keys whose value is stored as JSON {"az":"...","en":"...","ru":"..."}
    public const TRANSLATABLE = [
        'site_name', 'site_tagline',
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    public static function get(string $key, $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) return $default;

        $value = $setting->value;
        if (in_array($key, self::TRANSLATABLE) && str_starts_with((string) $value, '{')) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $locale = app()->getLocale();
                return $decoded[$locale] ?? $decoded['az'] ?? $default;
            }
        }
        return $value;
    }

    // Get raw array of all translations for a key
    public static function getTranslations(string $key): array
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) return ['az' => '', 'en' => '', 'ru' => ''];

        $value = $setting->value;
        if (str_starts_with((string) $value, '{')) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) return $decoded;
        }
        return ['az' => $value, 'en' => '', 'ru' => ''];
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}

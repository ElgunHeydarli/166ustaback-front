<?php

namespace Tests\Unit\Models;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_returns_null_when_key_not_found(): void
    {
        $this->assertNull(Setting::get('nonexistent_key'));
    }

    public function test_get_returns_default_when_key_not_found(): void
    {
        $this->assertEquals('default', Setting::get('nonexistent_key', 'default'));
    }

    public function test_get_returns_simple_string_value(): void
    {
        Setting::create(['key' => 'phone', 'value' => '+994501234567']);

        $this->assertEquals('+994501234567', Setting::get('phone'));
    }

    public function test_get_returns_az_translation_for_translatable_key(): void
    {
        Setting::create([
            'key'   => 'site_name',
            'value' => json_encode(['az' => '166 Usta', 'en' => '166 Master', 'ru' => '166 Мастер']),
        ]);

        app()->setLocale('az');
        $this->assertEquals('166 Usta', Setting::get('site_name'));
    }

    public function test_get_returns_en_translation_for_translatable_key(): void
    {
        Setting::create([
            'key'   => 'site_name',
            'value' => json_encode(['az' => '166 Usta', 'en' => '166 Master', 'ru' => '166 Мастер']),
        ]);

        app()->setLocale('en');
        $this->assertEquals('166 Master', Setting::get('site_name'));
    }

    public function test_get_returns_ru_translation_for_translatable_key(): void
    {
        Setting::create([
            'key'   => 'site_name',
            'value' => json_encode(['az' => '166 Usta', 'en' => '166 Master', 'ru' => '166 Мастер']),
        ]);

        app()->setLocale('ru');
        $this->assertEquals('166 Мастер', Setting::get('site_name'));
    }

    public function test_get_falls_back_to_az_when_locale_missing_from_translations(): void
    {
        Setting::create([
            'key'   => 'meta_title',
            'value' => json_encode(['az' => 'Sayt Adı', 'en' => 'Site Name']),
        ]);

        app()->setLocale('ru'); // 'ru' not in JSON
        $this->assertEquals('Sayt Adı', Setting::get('meta_title'));
    }

    public function test_set_creates_new_setting(): void
    {
        Setting::set('new_key', 'new_value');

        $this->assertDatabaseHas('settings', ['key' => 'new_key', 'value' => 'new_value']);
    }

    public function test_set_updates_existing_setting(): void
    {
        Setting::create(['key' => 'site_email', 'value' => 'old@test.com']);
        Setting::set('site_email', 'new@test.com');

        $this->assertDatabaseHas('settings', ['key' => 'site_email', 'value' => 'new@test.com']);
        $this->assertDatabaseMissing('settings', ['value' => 'old@test.com']);
    }

    public function test_set_does_not_create_duplicate_keys(): void
    {
        Setting::set('unique_key', 'value1');
        Setting::set('unique_key', 'value2');

        $this->assertEquals(1, Setting::where('key', 'unique_key')->count());
    }

    public function test_get_translations_returns_all_locales(): void
    {
        Setting::create([
            'key'   => 'meta_description',
            'value' => json_encode(['az' => 'AZ mətn', 'en' => 'EN text', 'ru' => 'RU текст']),
        ]);

        $result = Setting::getTranslations('meta_description');

        $this->assertEquals(['az' => 'AZ mətn', 'en' => 'EN text', 'ru' => 'RU текст'], $result);
    }

    public function test_get_translations_returns_default_array_when_not_found(): void
    {
        $result = Setting::getTranslations('nonexistent');

        $this->assertEquals(['az' => '', 'en' => '', 'ru' => ''], $result);
    }

    public function test_get_translations_wraps_plain_string_in_az(): void
    {
        Setting::create(['key' => 'plain_key', 'value' => 'plain text']);

        $result = Setting::getTranslations('plain_key');

        $this->assertEquals(['az' => 'plain text', 'en' => '', 'ru' => ''], $result);
    }

    public function test_translatable_constant_contains_expected_keys(): void
    {
        $expected = ['site_name', 'site_tagline', 'meta_title', 'meta_description', 'meta_keywords'];

        foreach ($expected as $key) {
            $this->assertContains($key, Setting::TRANSLATABLE);
        }
    }
}

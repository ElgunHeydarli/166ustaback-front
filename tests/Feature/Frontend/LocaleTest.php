<?php

namespace Tests\Feature\Frontend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleTest extends TestCase
{
    use RefreshDatabase;

    // ──────────────────────────────────────────
    // Locale setting via middleware
    // ──────────────────────────────────────────

    public function test_az_locale_is_set_when_visiting_az_prefix(): void
    {
        $this->get('/az');

        $this->assertEquals('az', app()->getLocale());
    }

    public function test_en_locale_is_set_when_visiting_en_prefix(): void
    {
        $this->get('/en');

        $this->assertEquals('en', app()->getLocale());
    }

    public function test_ru_locale_is_set_when_visiting_ru_prefix(): void
    {
        $this->get('/ru');

        $this->assertEquals('ru', app()->getLocale());
    }

    public function test_az_locale_stored_in_session(): void
    {
        $this->get('/az')->assertSessionHas('locale', 'az');
    }

    public function test_en_locale_stored_in_session(): void
    {
        $this->get('/en')->assertSessionHas('locale', 'en');
    }

    public function test_ru_locale_stored_in_session(): void
    {
        $this->get('/ru')->assertSessionHas('locale', 'ru');
    }

    // ──────────────────────────────────────────
    // Unknown locale routes
    // ──────────────────────────────────────────

    public function test_unknown_locale_fr_returns_404(): void
    {
        $this->get('/fr')->assertStatus(404);
    }

    public function test_unknown_locale_de_returns_404(): void
    {
        $this->get('/de')->assertStatus(404);
    }

    public function test_unknown_locale_tr_returns_404(): void
    {
        $this->get('/tr')->assertStatus(404);
    }

    // ──────────────────────────────────────────
    // Redirect from root
    // ──────────────────────────────────────────

    public function test_root_redirects_to_az_home(): void
    {
        $this->get('/')->assertRedirect('/az');
    }

    // ──────────────────────────────────────────
    // All locale prefixes work for main sections
    // ──────────────────────────────────────────

    public function test_all_locales_work_for_home_page(): void
    {
        foreach (['az', 'en', 'ru'] as $locale) {
            $this->get("/{$locale}")
                ->assertStatus(200, "Home page failed for locale: {$locale}");
        }
    }

    public function test_all_locales_work_for_services_index(): void
    {
        foreach (['az', 'en', 'ru'] as $locale) {
            $this->get("/{$locale}/xidmetler")
                ->assertStatus(200, "Services index failed for locale: {$locale}");
        }
    }

    public function test_all_locales_work_for_portfolio_index(): void
    {
        foreach (['az', 'en', 'ru'] as $locale) {
            $this->get("/{$locale}/portfolio")
                ->assertStatus(200, "Portfolio index failed for locale: {$locale}");
        }
    }

    public function test_all_locales_work_for_blog_index(): void
    {
        foreach (['az', 'en', 'ru'] as $locale) {
            $this->get("/{$locale}/bloq")
                ->assertStatus(200, "Blog index failed for locale: {$locale}");
        }
    }

    public function test_all_locales_work_for_boxes_index(): void
    {
        foreach (['az', 'en', 'ru'] as $locale) {
            $this->get("/{$locale}/qutular")
                ->assertStatus(200, "Boxes index failed for locale: {$locale}");
        }
    }

    public function test_all_locales_work_for_campaigns_index(): void
    {
        foreach (['az', 'en', 'ru'] as $locale) {
            $this->get("/{$locale}/kampaniyalar")
                ->assertStatus(200, "Campaigns index failed for locale: {$locale}");
        }
    }
}

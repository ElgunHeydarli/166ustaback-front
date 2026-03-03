<?php

namespace Tests\Feature\Frontend;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    use RefreshDatabase;

    private function makeCampaign(array $overrides = []): Campaign
    {
        return Campaign::create(array_merge([
            'title'             => ['az' => 'Yaz Kampaniyası', 'en' => 'Spring Campaign', 'ru' => 'Весенняя Кампания'],
            'slug'              => ['az' => 'yaz-kampaniyasi', 'en' => 'spring-campaign', 'ru' => 'vesennaya-kampaniya'],
            'short_description' => ['az' => 'Yaz endirimi', 'en' => 'Spring discount', 'ru' => 'Весенняя скидка'],
            'is_active'         => true,
        ], $overrides));
    }

    // ──────────────────────────────────────────
    // Index page tests
    // ──────────────────────────────────────────

    public function test_campaigns_index_returns_200(): void
    {
        $this->get('/az/kampaniyalar')->assertStatus(200);
    }

    public function test_campaigns_index_returns_200_for_en(): void
    {
        $this->get('/en/kampaniyalar')->assertStatus(200);
    }

    public function test_campaigns_index_returns_200_for_ru(): void
    {
        $this->get('/ru/kampaniyalar')->assertStatus(200);
    }

    public function test_campaigns_index_shows_active_campaign(): void
    {
        $this->makeCampaign();

        $this->get('/az/kampaniyalar')->assertSee('Yaz Kampaniyası');
    }

    public function test_campaigns_index_hides_inactive_campaign(): void
    {
        $this->makeCampaign(['is_active' => false]);

        $this->get('/az/kampaniyalar')->assertDontSee('Yaz Kampaniyası');
    }

    public function test_campaigns_index_shows_en_titles_for_en_locale(): void
    {
        $this->makeCampaign();

        $this->get('/en/kampaniyalar')
            ->assertSee('Spring Campaign')
            ->assertDontSee('Yaz Kampaniyası');
    }

    public function test_campaigns_index_with_empty_database_returns_200(): void
    {
        $this->get('/az/kampaniyalar')->assertStatus(200);
    }

    // ──────────────────────────────────────────
    // Show page tests
    // ──────────────────────────────────────────

    public function test_campaigns_show_returns_200_for_valid_az_slug(): void
    {
        $this->makeCampaign();

        $this->get('/az/kampaniyalar/yaz-kampaniyasi')->assertStatus(200);
    }

    public function test_campaigns_show_displays_title(): void
    {
        $this->makeCampaign();

        $this->get('/az/kampaniyalar/yaz-kampaniyasi')->assertSee('Yaz Kampaniyası');
    }

    public function test_campaigns_show_returns_200_for_en_locale(): void
    {
        $this->makeCampaign();

        $this->get('/en/kampaniyalar/spring-campaign')
            ->assertStatus(200)
            ->assertSee('Spring Campaign');
    }

    public function test_campaigns_show_returns_200_for_ru_locale(): void
    {
        $this->makeCampaign();

        $this->get('/ru/kampaniyalar/vesennaya-kampaniya')
            ->assertStatus(200)
            ->assertSee('Весенняя Кампания');
    }

    public function test_campaigns_show_returns_404_for_nonexistent_slug(): void
    {
        $this->get('/az/kampaniyalar/olmayan-kampaniya')->assertStatus(404);
    }

    public function test_campaigns_show_returns_404_for_inactive_campaign(): void
    {
        $this->makeCampaign([
            'is_active' => false,
            'slug'      => ['az' => 'gizli-kampaniya', 'en' => 'hidden-campaign', 'ru' => 'skritaya-kampaniya'],
        ]);

        $this->get('/az/kampaniyalar/gizli-kampaniya')->assertStatus(404);
    }

    public function test_campaigns_show_with_date_range(): void
    {
        Campaign::create([
            'title'      => ['az' => 'Müddətli Kampaniya', 'en' => 'Dated Campaign', 'ru' => 'Кампания с Датой'],
            'slug'       => ['az' => 'mudddetli-kampaniya', 'en' => 'dated-campaign', 'ru' => 'kampaniya-s-datoy'],
            'is_active'  => true,
            'starts_at'  => now()->subDays(5),
            'ends_at'    => now()->addDays(10),
        ]);

        $this->get('/az/kampaniyalar/mudddetli-kampaniya')->assertStatus(200);
    }
}

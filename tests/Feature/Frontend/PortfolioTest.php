<?php

namespace Tests\Feature\Frontend;

use App\Models\PortfolioItem;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    private function makeItem(array $overrides = []): PortfolioItem
    {
        return PortfolioItem::create(array_merge([
            'title'             => ['az' => 'Mənzil Təmiri', 'en' => 'Apartment Renovation', 'ru' => 'Ремонт Квартиры'],
            'slug'              => ['az' => 'menzil-temiri', 'en' => 'apartment-renovation', 'ru' => 'remont-kvartiry'],
            'short_description' => ['az' => 'Tam mənzil təmiri', 'en' => 'Full apartment renovation', 'ru' => 'Полный ремонт'],
            'is_active'         => true,
            'order'             => 1,
        ], $overrides));
    }

    // ──────────────────────────────────────────
    // Index page tests
    // ──────────────────────────────────────────

    public function test_portfolio_index_returns_200_for_az(): void
    {
        $this->get('/az/portfolio')->assertStatus(200);
    }

    public function test_portfolio_index_returns_200_for_en(): void
    {
        $this->get('/en/portfolio')->assertStatus(200);
    }

    public function test_portfolio_index_returns_200_for_ru(): void
    {
        $this->get('/ru/portfolio')->assertStatus(200);
    }

    public function test_portfolio_index_shows_active_item(): void
    {
        $this->makeItem();

        $this->get('/az/portfolio')->assertSee('Mənzil Təmiri');
    }

    public function test_portfolio_index_hides_inactive_item(): void
    {
        $this->makeItem(['is_active' => false]);

        $this->get('/az/portfolio')->assertDontSee('Mənzil Təmiri');
    }

    public function test_portfolio_index_shows_en_titles_for_en_locale(): void
    {
        $this->makeItem();

        $this->get('/en/portfolio')
            ->assertSee('Apartment Renovation')
            ->assertDontSee('Mənzil Təmiri');
    }

    public function test_portfolio_index_with_empty_database_returns_200(): void
    {
        $this->get('/az/portfolio')->assertStatus(200);
    }

    // ──────────────────────────────────────────
    // Show page tests
    // ──────────────────────────────────────────

    public function test_portfolio_show_returns_200_for_valid_az_slug(): void
    {
        $this->makeItem();

        $this->get('/az/portfolio/menzil-temiri')->assertStatus(200);
    }

    public function test_portfolio_show_displays_title(): void
    {
        $this->makeItem();

        $this->get('/az/portfolio/menzil-temiri')->assertSee('Mənzil Təmiri');
    }

    public function test_portfolio_show_returns_200_for_en_locale(): void
    {
        $this->makeItem();

        $this->get('/en/portfolio/apartment-renovation')
            ->assertStatus(200)
            ->assertSee('Apartment Renovation');
    }

    public function test_portfolio_show_returns_200_for_ru_locale(): void
    {
        $this->makeItem();

        $this->get('/ru/portfolio/remont-kvartiry')
            ->assertStatus(200)
            ->assertSee('Ремонт Квартиры');
    }

    public function test_portfolio_show_returns_404_for_nonexistent_slug(): void
    {
        $this->get('/az/portfolio/olmayan-portfolio')->assertStatus(404);
    }

    public function test_portfolio_show_returns_404_for_inactive_item(): void
    {
        $this->makeItem([
            'is_active' => false,
            'slug'      => ['az' => 'gizli-portfolio', 'en' => 'hidden-portfolio', 'ru' => 'skritoe-portfolio'],
        ]);

        $this->get('/az/portfolio/gizli-portfolio')->assertStatus(404);
    }

    public function test_portfolio_show_displays_client_when_present(): void
    {
        $this->makeItem(['client' => 'ABC Şirkəti']);

        $this->get('/az/portfolio/menzil-temiri')->assertSee('ABC Şirkəti');
    }

    public function test_portfolio_show_displays_duration_when_present(): void
    {
        $this->makeItem(['duration' => '2 həftə']);

        $this->get('/az/portfolio/menzil-temiri')->assertSee('2 həftə');
    }

    public function test_portfolio_show_with_service_relation(): void
    {
        $service = Service::create([
            'title'     => ['az' => 'Bağlı Xidmət', 'en' => 'Related Service', 'ru' => 'Связанная Услуга'],
            'slug'      => ['az' => 'bagli-xidmet', 'en' => 'related-service', 'ru' => 'svyazannaya-usluga'],
            'is_active' => true,
        ]);

        $this->makeItem(['service_id' => $service->id]);

        $this->get('/az/portfolio/menzil-temiri')->assertSee('Bağlı Xidmət');
    }
}

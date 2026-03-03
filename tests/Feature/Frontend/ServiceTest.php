<?php

namespace Tests\Feature\Frontend;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    private function makeService(array $overrides = []): Service
    {
        return Service::create(array_merge([
            'title'             => ['az' => 'Suvaq İşləri', 'en' => 'Plastering Work', 'ru' => 'Штукатурные Работы'],
            'slug'              => ['az' => 'suvaq-isleri', 'en' => 'plastering-work', 'ru' => 'shtukaturnie-raboty'],
            'short_description' => ['az' => 'Peşəkar suvaq', 'en' => 'Professional plastering', 'ru' => 'Профессиональная штукатурка'],
            'is_active'         => true,
            'order'             => 1,
        ], $overrides));
    }

    // ──────────────────────────────────────────
    // Index page tests
    // ──────────────────────────────────────────

    public function test_services_index_returns_200(): void
    {
        $this->get('/az/xidmetler')->assertStatus(200);
    }

    public function test_services_index_returns_200_for_en(): void
    {
        $this->get('/en/xidmetler')->assertStatus(200);
    }

    public function test_services_index_returns_200_for_ru(): void
    {
        $this->get('/ru/xidmetler')->assertStatus(200);
    }

    public function test_services_index_shows_active_service(): void
    {
        $this->makeService();

        $this->get('/az/xidmetler')->assertSee('Suvaq İşləri');
    }

    public function test_services_index_hides_inactive_service(): void
    {
        $this->makeService(['is_active' => false]);

        $this->get('/az/xidmetler')->assertDontSee('Suvaq İşləri');
    }

    public function test_services_index_shows_en_titles_for_en_locale(): void
    {
        $this->makeService();

        $this->get('/en/xidmetler')
            ->assertSee('Plastering Work')
            ->assertDontSee('Suvaq İşləri');
    }

    public function test_services_index_with_empty_database_returns_200(): void
    {
        $this->get('/az/xidmetler')->assertStatus(200);
    }

    // ──────────────────────────────────────────
    // Show page tests
    // ──────────────────────────────────────────

    public function test_services_show_returns_200_for_valid_az_slug(): void
    {
        $this->makeService();

        $this->get('/az/xidmetler/suvaq-isleri')->assertStatus(200);
    }

    public function test_services_show_displays_service_title(): void
    {
        $this->makeService();

        $this->get('/az/xidmetler/suvaq-isleri')->assertSee('Suvaq İşləri');
    }

    public function test_services_show_returns_200_for_en_locale(): void
    {
        $this->makeService();

        $this->get('/en/xidmetler/plastering-work')
            ->assertStatus(200)
            ->assertSee('Plastering Work');
    }

    public function test_services_show_returns_200_for_ru_locale(): void
    {
        $this->makeService();

        $this->get('/ru/xidmetler/shtukaturnie-raboty')
            ->assertStatus(200)
            ->assertSee('Штукатурные Работы');
    }

    public function test_services_show_returns_404_for_nonexistent_slug(): void
    {
        $this->get('/az/xidmetler/olmayan-xidmet')->assertStatus(404);
    }

    public function test_services_show_returns_404_for_inactive_service(): void
    {
        $this->makeService([
            'is_active' => false,
            'slug'      => ['az' => 'inactive-svc', 'en' => 'inactive-svc', 'ru' => 'inactive-svc'],
        ]);

        $this->get('/az/xidmetler/inactive-svc')->assertStatus(404);
    }

    public function test_services_index_respects_order(): void
    {
        Service::create([
            'title'     => ['az' => 'İkinci Xidmət', 'en' => 'Second', 'ru' => 'Второй'],
            'slug'      => ['az' => 'ikinci-xidmet', 'en' => 'second', 'ru' => 'vtoroy'],
            'is_active' => true,
            'order'     => 2,
        ]);
        Service::create([
            'title'     => ['az' => 'Birinci Xidmət', 'en' => 'First', 'ru' => 'Первый'],
            'slug'      => ['az' => 'birinci-xidmet', 'en' => 'first', 'ru' => 'perviy'],
            'is_active' => true,
            'order'     => 1,
        ]);

        $response = $this->get('/az/xidmetler');
        $content  = $response->getContent();

        $this->assertLessThan(
            strpos($content, 'İkinci Xidmət'),
            strpos($content, 'Birinci Xidmət')
        );
    }
}

<?php

namespace Tests\Feature\Frontend;

use App\Models\Box;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoxTest extends TestCase
{
    use RefreshDatabase;

    private function makeBox(array $overrides = []): Box
    {
        return Box::create(array_merge([
            'title'             => ['az' => 'Başlanğıc Qutu', 'en' => 'Starter Box', 'ru' => 'Стартовый Набор'],
            'slug'              => ['az' => 'bashlangic-qutu', 'en' => 'starter-box', 'ru' => 'startoviy-nabor'],
            'category'          => ['az' => 'Əsas', 'en' => 'Basic', 'ru' => 'Базовый'],
            'short_description' => ['az' => 'Əsas paket', 'en' => 'Basic package', 'ru' => 'Базовый пакет'],
            'price'             => 150.00,
            'is_active'         => true,
            'order'             => 1,
        ], $overrides));
    }

    // ──────────────────────────────────────────
    // Index page tests
    // ──────────────────────────────────────────

    public function test_boxes_index_returns_200(): void
    {
        $this->get('/az/qutular')->assertStatus(200);
    }

    public function test_boxes_index_returns_200_for_en(): void
    {
        $this->get('/en/qutular')->assertStatus(200);
    }

    public function test_boxes_index_returns_200_for_ru(): void
    {
        $this->get('/ru/qutular')->assertStatus(200);
    }

    public function test_boxes_index_shows_active_box(): void
    {
        $this->makeBox();

        $this->get('/az/qutular')->assertSee('Başlanğıc Qutu');
    }

    public function test_boxes_index_hides_inactive_box(): void
    {
        $this->makeBox(['is_active' => false]);

        $this->get('/az/qutular')->assertDontSee('Başlanğıc Qutu');
    }

    public function test_boxes_index_shows_en_titles_for_en_locale(): void
    {
        $this->makeBox();

        $this->get('/en/qutular')
            ->assertSee('Starter Box')
            ->assertDontSee('Başlanğıc Qutu');
    }

    public function test_boxes_index_with_empty_database_returns_200(): void
    {
        $this->get('/az/qutular')->assertStatus(200);
    }

    // ──────────────────────────────────────────
    // Show page tests
    // ──────────────────────────────────────────

    public function test_boxes_show_returns_200_for_valid_az_slug(): void
    {
        $this->makeBox();

        $this->get('/az/qutular/bashlangic-qutu')->assertStatus(200);
    }

    public function test_boxes_show_displays_title(): void
    {
        $this->makeBox();

        $this->get('/az/qutular/bashlangic-qutu')->assertSee('Başlanğıc Qutu');
    }

    public function test_boxes_show_displays_price(): void
    {
        $this->makeBox(['price' => 150.00]);

        $this->get('/az/qutular/bashlangic-qutu')->assertSee('150');
    }

    public function test_boxes_show_returns_200_for_en_locale(): void
    {
        $this->makeBox();

        $this->get('/en/qutular/starter-box')
            ->assertStatus(200)
            ->assertSee('Starter Box');
    }

    public function test_boxes_show_returns_200_for_ru_locale(): void
    {
        $this->makeBox();

        $this->get('/ru/qutular/startoviy-nabor')
            ->assertStatus(200)
            ->assertSee('Стартовый Набор');
    }

    public function test_boxes_show_returns_404_for_nonexistent_slug(): void
    {
        $this->get('/az/qutular/olmayan-qutu')->assertStatus(404);
    }

    public function test_boxes_show_returns_404_for_inactive_box(): void
    {
        $this->makeBox([
            'is_active' => false,
            'slug'      => ['az' => 'gizli-qutu', 'en' => 'hidden-box', 'ru' => 'skritiy-nabor'],
        ]);

        $this->get('/az/qutular/gizli-qutu')->assertStatus(404);
    }

    public function test_boxes_show_displays_short_description(): void
    {
        $this->makeBox();

        $this->get('/az/qutular/bashlangic-qutu')->assertSee('Əsas paket');
    }
}

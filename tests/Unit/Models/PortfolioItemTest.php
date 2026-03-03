<?php

namespace Tests\Unit\Models;

use App\Models\PortfolioItem;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioItemTest extends TestCase
{
    use RefreshDatabase;

    private function makeItem(array $overrides = []): PortfolioItem
    {
        return PortfolioItem::create(array_merge([
            'title'             => ['az' => 'Test Layihə', 'en' => 'Test Project', 'ru' => 'Тест Проект'],
            'slug'              => ['az' => 'test-layihe', 'en' => 'test-project', 'ru' => 'test-proekt'],
            'short_description' => ['az' => 'Qısa', 'en' => 'Short', 'ru' => 'Краткий'],
            'is_active'         => true,
            'order'             => 1,
        ], $overrides));
    }

    public function test_portfolio_item_can_be_created(): void
    {
        $item = $this->makeItem();

        $this->assertNotNull($item->id);
        $this->assertDatabaseHas('portfolio_items', ['id' => $item->id]);
    }

    public function test_title_is_translatable(): void
    {
        $item = $this->makeItem();

        $this->assertEquals('Test Layihə', $item->getTranslation('title', 'az'));
        $this->assertEquals('Test Project', $item->getTranslation('title', 'en'));
        $this->assertEquals('Тест Проект', $item->getTranslation('title', 'ru'));
    }

    public function test_slug_is_translatable(): void
    {
        $item = $this->makeItem();

        $this->assertEquals('test-layihe', $item->getTranslation('slug', 'az'));
        $this->assertEquals('test-project', $item->getTranslation('slug', 'en'));
    }

    public function test_is_active_is_cast_to_boolean(): void
    {
        $item = $this->makeItem(['is_active' => true]);

        $this->assertIsBool($item->is_active);
        $this->assertTrue($item->is_active);
    }

    public function test_gallery_is_cast_to_array(): void
    {
        $item = $this->makeItem(['gallery' => ['img1.jpg', 'img2.jpg', 'img3.jpg']]);

        $fresh = $item->fresh();
        $this->assertIsArray($fresh->gallery);
        $this->assertCount(3, $fresh->gallery);
        $this->assertContains('img1.jpg', $fresh->gallery);
    }

    public function test_gallery_can_be_null(): void
    {
        $item = $this->makeItem(['gallery' => null]);

        $this->assertNull($item->fresh()->gallery);
    }

    public function test_client_field_is_stored(): void
    {
        $item = $this->makeItem(['client' => 'ABC Şirkəti']);

        $this->assertEquals('ABC Şirkəti', $item->fresh()->client);
    }

    public function test_duration_field_is_stored(): void
    {
        $item = $this->makeItem(['duration' => '3 ay']);

        $this->assertEquals('3 ay', $item->fresh()->duration);
    }

    public function test_belongs_to_service(): void
    {
        $service = Service::create([
            'title'     => ['az' => 'Xidmət', 'en' => 'Service', 'ru' => 'Услуга'],
            'slug'      => ['az' => 'xidmet', 'en' => 'service', 'ru' => 'usluga'],
            'is_active' => true,
        ]);

        $item = $this->makeItem(['service_id' => $service->id]);

        $this->assertNotNull($item->service);
        $this->assertEquals($service->id, $item->service->id);
        $this->assertEquals('Xidmət', $item->service->getTranslation('title', 'az'));
    }

    public function test_service_relationship_is_null_when_no_service(): void
    {
        $item = $this->makeItem(['service_id' => null]);

        $this->assertNull($item->fresh()->service);
    }

    public function test_cover_image_is_stored(): void
    {
        $item = $this->makeItem(['cover_image' => 'portfolio/cover.jpg']);

        $this->assertEquals('portfolio/cover.jpg', $item->fresh()->cover_image);
    }

    public function test_translatable_fields_list(): void
    {
        $item = new PortfolioItem();

        foreach (['title', 'slug', 'short_description', 'content', 'meta_title', 'meta_description', 'meta_keywords'] as $field) {
            $this->assertContains($field, $item->translatable);
        }
    }
}

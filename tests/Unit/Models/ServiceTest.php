<?php

namespace Tests\Unit\Models;

use App\Models\PortfolioItem;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    private function makeService(array $overrides = []): Service
    {
        return Service::create(array_merge([
            'title'             => ['az' => 'Test Xidmət', 'en' => 'Test Service', 'ru' => 'Тест Услуга'],
            'slug'              => ['az' => 'test-xidmet', 'en' => 'test-service', 'ru' => 'test-usluga'],
            'short_description' => ['az' => 'Qısa məlumat', 'en' => 'Short info', 'ru' => 'Краткая информация'],
            'is_active'         => true,
            'order'             => 1,
        ], $overrides));
    }

    public function test_service_can_be_created(): void
    {
        $service = $this->makeService();

        $this->assertNotNull($service->id);
        $this->assertDatabaseHas('services', ['id' => $service->id]);
    }

    public function test_title_is_translatable(): void
    {
        $service = $this->makeService();

        $this->assertEquals('Test Xidmət', $service->getTranslation('title', 'az'));
        $this->assertEquals('Test Service', $service->getTranslation('title', 'en'));
        $this->assertEquals('Тест Услуга', $service->getTranslation('title', 'ru'));
    }

    public function test_slug_is_translatable(): void
    {
        $service = $this->makeService();

        $this->assertEquals('test-xidmet', $service->getTranslation('slug', 'az'));
        $this->assertEquals('test-service', $service->getTranslation('slug', 'en'));
        $this->assertEquals('test-usluga', $service->getTranslation('slug', 'ru'));
    }

    public function test_is_active_is_cast_to_boolean(): void
    {
        $service = $this->makeService(['is_active' => true]);

        $this->assertIsBool($service->is_active);
        $this->assertTrue($service->is_active);
    }

    public function test_show_in_menu_is_cast_to_boolean(): void
    {
        $service = $this->makeService(['show_in_menu' => false]);

        $this->assertIsBool($service->fresh()->show_in_menu);
        $this->assertFalse($service->fresh()->show_in_menu);
    }

    public function test_images_is_cast_to_array(): void
    {
        $service = $this->makeService(['images' => ['img1.jpg', 'img2.jpg']]);

        $fresh = $service->fresh();
        $this->assertIsArray($fresh->images);
        $this->assertCount(2, $fresh->images);
        $this->assertContains('img1.jpg', $fresh->images);
    }

    public function test_advantages_is_cast_to_array(): void
    {
        $service = $this->makeService([
            'advantages' => [
                'az' => ['Üstünlük 1', 'Üstünlük 2', 'Üstünlük 3', 'Üstünlük 4'],
                'en' => ['Advantage 1', 'Advantage 2', 'Advantage 3', 'Advantage 4'],
            ],
        ]);

        $this->assertIsArray($service->fresh()->advantages);
    }

    public function test_get_advantages_returns_correct_locale(): void
    {
        $service = $this->makeService([
            'advantages' => [
                'az' => ['AZ 1', 'AZ 2', 'AZ 3', 'AZ 4'],
                'en' => ['EN 1', 'EN 2', 'EN 3', 'EN 4'],
            ],
        ]);

        $az = $service->fresh()->getAdvantages('az');
        $this->assertEquals(['AZ 1', 'AZ 2', 'AZ 3', 'AZ 4'], $az);

        $en = $service->fresh()->getAdvantages('en');
        $this->assertEquals(['EN 1', 'EN 2', 'EN 3', 'EN 4'], $en);
    }

    public function test_get_advantages_falls_back_to_az_when_locale_missing(): void
    {
        $service = $this->makeService([
            'advantages' => ['az' => ['AZ 1', 'AZ 2', 'AZ 3', 'AZ 4']],
        ]);

        $result = $service->fresh()->getAdvantages('ru');
        $this->assertEquals(['AZ 1', 'AZ 2', 'AZ 3', 'AZ 4'], $result);
    }

    public function test_get_advantages_returns_empty_array_when_null(): void
    {
        $service = $this->makeService(['advantages' => null]);

        $result = $service->fresh()->getAdvantages('az');
        $this->assertEquals(['', '', '', ''], $result);
    }

    public function test_steps_is_cast_to_array(): void
    {
        $steps = [
            ['title' => ['az' => 'Addım 1', 'en' => 'Step 1'], 'description' => ['az' => 'Açıqlama 1']],
            ['title' => ['az' => 'Addım 2', 'en' => 'Step 2'], 'description' => ['az' => 'Açıqlama 2']],
        ];

        $service = $this->makeService(['steps' => $steps]);

        $this->assertIsArray($service->fresh()->steps);
        $this->assertCount(2, $service->fresh()->steps);
    }

    public function test_get_steps_returns_array(): void
    {
        $steps = [
            ['title' => ['az' => 'Addım 1'], 'description' => ['az' => 'Açıqlama']],
        ];
        $service = $this->makeService(['steps' => $steps]);

        $result = $service->fresh()->getSteps();
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
    }

    public function test_get_steps_returns_empty_array_when_null(): void
    {
        $service = $this->makeService(['steps' => null]);

        $result = $service->fresh()->getSteps();
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function test_has_portfolio_items_relationship(): void
    {
        $service = $this->makeService();
        PortfolioItem::create([
            'title'      => ['az' => 'Portfolio', 'en' => 'Portfolio', 'ru' => 'Портфолио'],
            'slug'       => ['az' => 'portfolio-1', 'en' => 'portfolio-1', 'ru' => 'portfolio-1'],
            'service_id' => $service->id,
            'is_active'  => true,
        ]);

        $this->assertCount(1, $service->portfolioItems);
    }

    public function test_has_testimonials_relationship(): void
    {
        $service = $this->makeService();
        Testimonial::create([
            'customer_name' => 'Test Müştəri',
            'position'      => ['az' => 'Direktor', 'en' => 'Director', 'ru' => 'Директор'],
            'review_text'   => ['az' => 'Çox yaxşı', 'en' => 'Very good', 'ru' => 'Очень хорошо'],
            'service_id'    => $service->id,
            'is_active'     => true,
        ]);

        $this->assertCount(1, $service->testimonials);
    }

    public function test_translatable_fields_list(): void
    {
        $service = new Service();

        foreach (['title', 'slug', 'short_description', 'content', 'meta_title', 'meta_description', 'meta_keywords'] as $field) {
            $this->assertContains($field, $service->translatable);
        }
    }
}

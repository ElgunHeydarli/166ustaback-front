<?php

namespace Tests\Unit\Models;

use App\Models\Slider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SliderTest extends TestCase
{
    use RefreshDatabase;

    private function makeSlider(array $overrides = []): Slider
    {
        return Slider::create(array_merge([
            'title'       => ['az' => 'Slayd Başlığı', 'en' => 'Slider Title', 'ru' => 'Заголовок Слайдера'],
            'subtitle'    => ['az' => 'Alt başlıq', 'en' => 'Subtitle', 'ru' => 'Подзаголовок'],
            'button_text' => ['az' => 'Ətraflı', 'en' => 'Learn More', 'ru' => 'Подробнее'],
            'button_url'  => '/az/xidmetler',
            'image'       => '',
            'order'       => 1,
            'is_active'   => true,
        ], $overrides));
    }

    public function test_slider_can_be_created(): void
    {
        $slider = $this->makeSlider();

        $this->assertNotNull($slider->id);
        $this->assertDatabaseHas('sliders', ['id' => $slider->id]);
    }

    public function test_title_is_translatable(): void
    {
        $slider = $this->makeSlider();

        $this->assertEquals('Slayd Başlığı', $slider->getTranslation('title', 'az'));
        $this->assertEquals('Slider Title', $slider->getTranslation('title', 'en'));
        $this->assertEquals('Заголовок Слайдера', $slider->getTranslation('title', 'ru'));
    }

    public function test_subtitle_is_translatable(): void
    {
        $slider = $this->makeSlider();

        $this->assertEquals('Alt başlıq', $slider->getTranslation('subtitle', 'az'));
        $this->assertEquals('Subtitle', $slider->getTranslation('subtitle', 'en'));
        $this->assertEquals('Подзаголовок', $slider->getTranslation('subtitle', 'ru'));
    }

    public function test_button_text_is_translatable(): void
    {
        $slider = $this->makeSlider();

        $this->assertEquals('Ətraflı', $slider->getTranslation('button_text', 'az'));
        $this->assertEquals('Learn More', $slider->getTranslation('button_text', 'en'));
        $this->assertEquals('Подробнее', $slider->getTranslation('button_text', 'ru'));
    }

    public function test_is_active_is_cast_to_boolean_true(): void
    {
        $slider = $this->makeSlider(['is_active' => true]);

        $this->assertIsBool($slider->is_active);
        $this->assertTrue($slider->is_active);
    }

    public function test_is_active_is_cast_to_boolean_false(): void
    {
        $slider = $this->makeSlider(['is_active' => false]);

        $this->assertIsBool($slider->is_active);
        $this->assertFalse($slider->is_active);
    }

    public function test_sliders_ordered_by_order_column(): void
    {
        Slider::create(['title' => ['az' => 'Üçüncü'], 'image' => '', 'order' => 3, 'is_active' => true]);
        Slider::create(['title' => ['az' => 'Birinci'], 'image' => '', 'order' => 1, 'is_active' => true]);
        Slider::create(['title' => ['az' => 'İkinci'],  'image' => '', 'order' => 2, 'is_active' => true]);

        $sliders = Slider::where('is_active', true)->orderBy('order')->get();

        $this->assertEquals('Birinci', $sliders[0]->getTranslation('title', 'az'));
        $this->assertEquals('İkinci', $sliders[1]->getTranslation('title', 'az'));
        $this->assertEquals('Üçüncü', $sliders[2]->getTranslation('title', 'az'));
    }

    public function test_only_active_sliders_returned_with_scope(): void
    {
        $this->makeSlider(['is_active' => true, 'title' => ['az' => 'Aktiv', 'en' => 'Active', 'ru' => 'Активный']]);
        $this->makeSlider(['is_active' => false, 'title' => ['az' => 'Deaktiv', 'en' => 'Inactive', 'ru' => 'Неактивный'], 'order' => 2]);

        $active = Slider::where('is_active', true)->get();
        $this->assertCount(1, $active);
        $this->assertEquals('Aktiv', $active->first()->getTranslation('title', 'az'));
    }

    public function test_translatable_fields_list(): void
    {
        $slider = new Slider();

        foreach (['title', 'subtitle', 'button_text'] as $field) {
            $this->assertContains($field, $slider->translatable);
        }
    }
}

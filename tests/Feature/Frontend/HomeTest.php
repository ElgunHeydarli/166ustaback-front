<?php

namespace Tests\Feature\Frontend;

use App\Models\BlogPost;
use App\Models\Service;
use App\Models\Slider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_url_redirects_to_az(): void
    {
        $this->get('/')->assertRedirect('/az');
    }

    public function test_home_page_loads_for_az_locale(): void
    {
        $this->get('/az')->assertStatus(200);
    }

    public function test_home_page_loads_for_en_locale(): void
    {
        $this->get('/en')->assertStatus(200);
    }

    public function test_home_page_loads_for_ru_locale(): void
    {
        $this->get('/ru')->assertStatus(200);
    }

    public function test_home_page_with_empty_database_does_not_crash(): void
    {
        $this->get('/az')->assertStatus(200);
    }

    public function test_home_page_shows_active_slider_title(): void
    {
        Slider::create([
            'title'     => ['az' => 'Slayd Başlığı', 'en' => 'Slider Title', 'ru' => 'Заголовок'],
            'image'     => '',
            'is_active' => true,
            'order'     => 1,
        ]);

        $this->get('/az')->assertSee('Slayd Başlığı');
    }

    public function test_home_page_does_not_show_inactive_slider(): void
    {
        Slider::create([
            'title'     => ['az' => 'Deaktiv Slayd', 'en' => 'Inactive Slider', 'ru' => 'Неактивный'],
            'image'     => '',
            'is_active' => false,
        ]);

        $this->get('/az')->assertDontSee('Deaktiv Slayd');
    }

    public function test_home_page_shows_active_service(): void
    {
        Service::create([
            'title'     => ['az' => 'Evlərin Üzü', 'en' => 'Facade Work', 'ru' => 'Фасадные Работы'],
            'slug'      => ['az' => 'evlerin-uzu', 'en' => 'facade-work', 'ru' => 'fasadnye-raboty'],
            'is_active' => true,
            'order'     => 1,
        ]);

        $this->get('/az')->assertSee('Evlərin Üzü');
    }

    public function test_home_page_does_not_show_inactive_service(): void
    {
        Service::create([
            'title'     => ['az' => 'Gizli Xidmət', 'en' => 'Hidden Service', 'ru' => 'Скрытая Услуга'],
            'slug'      => ['az' => 'gizli-xidmet', 'en' => 'hidden-service', 'ru' => 'skrytaya-usluga'],
            'is_active' => false,
        ]);

        $this->get('/az')->assertDontSee('Gizli Xidmət');
    }

    public function test_home_page_shows_recent_blog_posts(): void
    {
        BlogPost::create([
            'title'        => ['az' => 'Son Məqalə', 'en' => 'Latest Article', 'ru' => 'Последняя Статья'],
            'slug'         => ['az' => 'son-meqale', 'en' => 'latest-article', 'ru' => 'poslednyaya-statya'],
            'is_active'    => true,
            'published_at' => now(),
        ]);

        $this->get('/az')->assertSee('Son Məqalə');
    }

    public function test_home_page_en_shows_english_content(): void
    {
        Service::create([
            'title'     => ['az' => 'AZ Xidmət', 'en' => 'EN Service', 'ru' => 'RU Услуга'],
            'slug'      => ['az' => 'az-xidmet', 'en' => 'en-service', 'ru' => 'ru-usluga'],
            'is_active' => true,
            'order'     => 1,
        ]);

        $this->get('/en')->assertSee('EN Service')->assertDontSee('AZ Xidmət');
    }

    public function test_home_page_ru_shows_russian_content(): void
    {
        Service::create([
            'title'     => ['az' => 'AZ Xidmət', 'en' => 'EN Service', 'ru' => 'RU Услуга'],
            'slug'      => ['az' => 'az-xidmet2', 'en' => 'en-service2', 'ru' => 'ru-usluga2'],
            'is_active' => true,
            'order'     => 1,
        ]);

        $this->get('/ru')->assertSee('RU Услуга');
    }
}

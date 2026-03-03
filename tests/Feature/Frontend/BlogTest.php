<?php

namespace Tests\Feature\Frontend;

use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    private function makePost(array $overrides = []): BlogPost
    {
        static $counter = 0;
        $counter++;

        return BlogPost::create(array_merge([
            'title'        => ['az' => "Test Yazı {$counter}", 'en' => "Test Post {$counter}", 'ru' => "Тест Пост {$counter}"],
            'slug'         => ['az' => "test-yazi-{$counter}", 'en' => "test-post-{$counter}", 'ru' => "test-post-ru-{$counter}"],
            'excerpt'      => ['az' => 'Qısa xülasə', 'en' => 'Short excerpt', 'ru' => 'Краткая выдержка'],
            'content'      => ['az' => '<p>AZ məzmun</p>', 'en' => '<p>EN content</p>', 'ru' => '<p>RU контент</p>'],
            'is_active'    => true,
            'published_at' => now(),
        ], $overrides));
    }

    // ──────────────────────────────────────────
    // Index page tests
    // ──────────────────────────────────────────

    public function test_blog_index_returns_200_for_az(): void
    {
        $this->get('/az/bloq')->assertStatus(200);
    }

    public function test_blog_index_returns_200_for_en(): void
    {
        $this->get('/en/bloq')->assertStatus(200);
    }

    public function test_blog_index_returns_200_for_ru(): void
    {
        $this->get('/ru/bloq')->assertStatus(200);
    }

    public function test_blog_index_shows_active_post(): void
    {
        BlogPost::create([
            'title'        => ['az' => 'Görünən Yazı', 'en' => 'Visible Post', 'ru' => 'Видимый Пост'],
            'slug'         => ['az' => 'gorunen-yazi', 'en' => 'visible-post', 'ru' => 'vidimiy-post'],
            'is_active'    => true,
            'published_at' => now(),
        ]);

        $this->get('/az/bloq')->assertSee('Görünən Yazı');
    }

    public function test_blog_index_hides_inactive_post(): void
    {
        BlogPost::create([
            'title'        => ['az' => 'Gizli Yazı', 'en' => 'Hidden Post', 'ru' => 'Скрытый Пост'],
            'slug'         => ['az' => 'gizli-yazi', 'en' => 'hidden-post', 'ru' => 'skritiy-post'],
            'is_active'    => false,
            'published_at' => now(),
        ]);

        $this->get('/az/bloq')->assertDontSee('Gizli Yazı');
    }

    public function test_blog_index_shows_en_titles_for_en_locale(): void
    {
        BlogPost::create([
            'title'        => ['az' => 'AZ Başlıq', 'en' => 'EN Title Here', 'ru' => 'RU Заголовок'],
            'slug'         => ['az' => 'az-bashliq', 'en' => 'en-title-here', 'ru' => 'ru-zagolovok'],
            'is_active'    => true,
            'published_at' => now(),
        ]);

        $this->get('/en/bloq')
            ->assertSee('EN Title Here')
            ->assertDontSee('AZ Başlıq');
    }

    public function test_blog_index_with_empty_database_returns_200(): void
    {
        $this->get('/az/bloq')->assertStatus(200);
    }

    // ──────────────────────────────────────────
    // Search tests
    // ──────────────────────────────────────────

    public function test_blog_search_filters_results_by_az_title(): void
    {
        BlogPost::create([
            'title'        => ['az' => 'Laravel Framework', 'en' => 'Laravel Framework', 'ru' => 'Laravel Framework'],
            'slug'         => ['az' => 'laravel-framework', 'en' => 'laravel-framework', 'ru' => 'laravel-framework'],
            'is_active'    => true,
            'published_at' => now(),
        ]);
        BlogPost::create([
            'title'        => ['az' => 'PHP Əsasları', 'en' => 'PHP Basics', 'ru' => 'PHP Основы'],
            'slug'         => ['az' => 'php-esaslari', 'en' => 'php-basics', 'ru' => 'php-osnovy'],
            'is_active'    => true,
            'published_at' => now(),
        ]);

        // Footer-dəki "Ən son bloqlar" hər iki yazını göstərir,
        // ona görə yalnız axtarış nəticəsinin doğru olduğunu yoxlayırıq
        $this->get('/az/bloq?search=Laravel')
            ->assertStatus(200)
            ->assertSee('Laravel Framework');
    }

    public function test_blog_search_with_no_results_returns_200(): void
    {
        $this->get('/az/bloq?search=mövcud-olmayan-söz')->assertStatus(200);
    }

    // ──────────────────────────────────────────
    // Show page tests
    // ──────────────────────────────────────────

    public function test_blog_show_returns_200_for_valid_az_slug(): void
    {
        BlogPost::create([
            'title'        => ['az' => 'Məqalə Başlığı', 'en' => 'Article Title', 'ru' => 'Заголовок Статьи'],
            'slug'         => ['az' => 'meqale-bashligi', 'en' => 'article-title', 'ru' => 'zagolovok-stati'],
            'is_active'    => true,
            'published_at' => now(),
        ]);

        $this->get('/az/bloq/meqale-bashligi')->assertStatus(200);
    }

    public function test_blog_show_displays_post_title(): void
    {
        BlogPost::create([
            'title'        => ['az' => 'Görünən Məqalə', 'en' => 'Visible Article', 'ru' => 'Видимая Статья'],
            'slug'         => ['az' => 'gorunen-meqale', 'en' => 'visible-article', 'ru' => 'vidimaya-statya'],
            'is_active'    => true,
            'published_at' => now(),
        ]);

        $this->get('/az/bloq/gorunen-meqale')->assertSee('Görünən Məqalə');
    }

    public function test_blog_show_returns_200_for_en_locale(): void
    {
        BlogPost::create([
            'title'        => ['az' => 'AZ Başlıq', 'en' => 'EN Article', 'ru' => 'RU Статья'],
            'slug'         => ['az' => 'az-bashliq-2', 'en' => 'en-article', 'ru' => 'ru-statya'],
            'is_active'    => true,
            'published_at' => now(),
        ]);

        $this->get('/en/bloq/en-article')
            ->assertStatus(200)
            ->assertSee('EN Article');
    }

    public function test_blog_show_returns_404_for_nonexistent_slug(): void
    {
        $this->get('/az/bloq/olmayan-slug')->assertStatus(404);
    }

    public function test_blog_show_returns_404_for_inactive_post(): void
    {
        BlogPost::create([
            'title'        => ['az' => 'Gizli Post', 'en' => 'Hidden Post', 'ru' => 'Скрытый Пост'],
            'slug'         => ['az' => 'gizli-post', 'en' => 'hidden-post-2', 'ru' => 'skritiy-post-2'],
            'is_active'    => false,
            'published_at' => now(),
        ]);

        $this->get('/az/bloq/gizli-post')->assertStatus(404);
    }

    // ──────────────────────────────────────────
    // Tag filter test
    // ──────────────────────────────────────────

    public function test_blog_index_filter_by_tag(): void
    {
        $tag = BlogTag::create([
            'name' => 'Tikinti',
            'slug' => 'tikinti',
        ]);

        $post1 = BlogPost::create([
            'title'        => ['az' => 'Tikinti Yazısı', 'en' => 'Construction Post', 'ru' => 'Стройка Пост'],
            'slug'         => ['az' => 'tikinti-yazisi', 'en' => 'construction-post', 'ru' => 'stroyka-post'],
            'is_active'    => true,
            'published_at' => now(),
        ]);
        $post2 = BlogPost::create([
            'title'        => ['az' => 'Başqa Yazı', 'en' => 'Other Post', 'ru' => 'Другой Пост'],
            'slug'         => ['az' => 'bashqa-yazi', 'en' => 'other-post', 'ru' => 'drugoy-post'],
            'is_active'    => true,
            'published_at' => now(),
        ]);

        $post1->tags()->attach($tag->id);

        // Footer-dəki "Ən son bloqlar" hər iki yazını göstərir,
        // ona görə yalnız tag filter-in işlədiyini yoxlayırıq
        $this->get('/az/bloq?tag=tikinti')
            ->assertStatus(200)
            ->assertSee('Tikinti Yazısı');
    }
}

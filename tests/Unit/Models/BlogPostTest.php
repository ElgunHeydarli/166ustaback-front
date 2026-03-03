<?php

namespace Tests\Unit\Models;

use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPostTest extends TestCase
{
    use RefreshDatabase;

    private function makePost(array $overrides = []): BlogPost
    {
        return BlogPost::create(array_merge([
            'title'        => ['az' => 'Test Başlıq', 'en' => 'Test Title', 'ru' => 'Тест Заголовок'],
            'slug'         => ['az' => 'test-bashliq', 'en' => 'test-title', 'ru' => 'test-zagolovok'],
            'excerpt'      => ['az' => 'AZ xülasə', 'en' => 'EN excerpt', 'ru' => 'RU выдержка'],
            'content'      => ['az' => '<p>AZ məzmun</p>', 'en' => '<p>EN content</p>', 'ru' => '<p>RU контент</p>'],
            'is_active'    => true,
            'published_at' => now(),
        ], $overrides));
    }

    public function test_blog_post_can_be_created(): void
    {
        $post = $this->makePost();

        $this->assertNotNull($post->id);
        $this->assertDatabaseHas('blog_posts', ['id' => $post->id]);
    }

    public function test_title_is_translatable(): void
    {
        $post = $this->makePost();

        $this->assertEquals('Test Başlıq', $post->getTranslation('title', 'az'));
        $this->assertEquals('Test Title', $post->getTranslation('title', 'en'));
        $this->assertEquals('Тест Заголовок', $post->getTranslation('title', 'ru'));
    }

    public function test_slug_is_translatable(): void
    {
        $post = $this->makePost();

        $this->assertEquals('test-bashliq', $post->getTranslation('slug', 'az'));
        $this->assertEquals('test-title', $post->getTranslation('slug', 'en'));
        $this->assertEquals('test-zagolovok', $post->getTranslation('slug', 'ru'));
    }

    public function test_excerpt_is_translatable(): void
    {
        $post = $this->makePost();

        $this->assertEquals('AZ xülasə', $post->getTranslation('excerpt', 'az'));
        $this->assertEquals('EN excerpt', $post->getTranslation('excerpt', 'en'));
    }

    public function test_content_is_translatable(): void
    {
        $post = $this->makePost();

        $this->assertStringContainsString('AZ məzmun', $post->getTranslation('content', 'az'));
        $this->assertStringContainsString('EN content', $post->getTranslation('content', 'en'));
    }

    public function test_is_active_is_cast_to_boolean_true(): void
    {
        $post = $this->makePost(['is_active' => true]);

        $this->assertIsBool($post->is_active);
        $this->assertTrue($post->is_active);
    }

    public function test_is_active_is_cast_to_boolean_false(): void
    {
        $post = $this->makePost([
            'is_active' => false,
            'slug'      => ['az' => 'inactive', 'en' => 'inactive', 'ru' => 'inactive'],
        ]);

        $this->assertIsBool($post->is_active);
        $this->assertFalse($post->is_active);
    }

    public function test_published_at_is_cast_to_carbon_instance(): void
    {
        $post = $this->makePost(['published_at' => '2026-01-15 10:00:00']);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $post->published_at);
        $this->assertEquals(2026, $post->published_at->year);
        $this->assertEquals(1, $post->published_at->month);
        $this->assertEquals(15, $post->published_at->day);
    }

    public function test_published_at_can_be_null(): void
    {
        $post = $this->makePost([
            'published_at' => null,
            'slug'         => ['az' => 'no-date', 'en' => 'no-date', 'ru' => 'no-date'],
        ]);

        $this->assertNull($post->fresh()->published_at);
    }

    public function test_has_tags_relationship(): void
    {
        $post = $this->makePost();
        $tag  = BlogTag::create([
            'name'      => ['az' => 'Laravel', 'en' => 'Laravel', 'ru' => 'Laravel'],
            'slug'      => 'laravel',
            'is_active' => true,
        ]);

        $post->tags()->attach($tag->id);

        $this->assertCount(1, $post->fresh()->tags);
        $this->assertEquals($tag->id, $post->fresh()->tags->first()->id);
    }

    public function test_can_attach_multiple_tags(): void
    {
        $post = $this->makePost();
        $tag1 = BlogTag::create(['name' => ['az' => 'Tag1', 'en' => 'Tag1', 'ru' => 'Tag1'], 'slug' => 'tag1', 'is_active' => true]);
        $tag2 = BlogTag::create(['name' => ['az' => 'Tag2', 'en' => 'Tag2', 'ru' => 'Tag2'], 'slug' => 'tag2', 'is_active' => true]);

        $post->tags()->attach([$tag1->id, $tag2->id]);

        $this->assertCount(2, $post->fresh()->tags);
    }

    public function test_translatable_fields_list(): void
    {
        $post = new BlogPost();

        foreach (['title', 'slug', 'excerpt', 'content', 'meta_title', 'meta_description', 'meta_keywords'] as $field) {
            $this->assertContains($field, $post->translatable);
        }
    }

    public function test_get_translation_returns_empty_string_for_missing_locale(): void
    {
        $post = BlogPost::create([
            'title'     => ['az' => 'Yalnız AZ'],
            'slug'      => ['az' => 'yalniz-az', 'en' => 'yalniz-az', 'ru' => 'yalniz-az'],
            'is_active' => true,
        ]);

        $this->assertEquals('', $post->getTranslation('title', 'en'));
    }
}

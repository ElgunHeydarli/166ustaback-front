<?php

namespace Tests\Unit\Traits;

use App\Models\BlogPost;
use App\Models\PortfolioItem;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CleansUpMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_single_cover_image_deleted_on_model_delete(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('blog/cover.jpg', 'fake image content');

        $post = BlogPost::create([
            'title'       => ['az' => 'Test', 'en' => 'Test', 'ru' => 'Test'],
            'slug'        => ['az' => 'test-1', 'en' => 'test-1', 'ru' => 'test-1'],
            'cover_image' => 'blog/cover.jpg',
            'is_active'   => true,
        ]);

        Storage::disk('public')->assertExists('blog/cover.jpg');

        $post->delete();

        Storage::disk('public')->assertMissing('blog/cover.jpg');
    }

    public function test_og_image_deleted_on_model_delete(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('blog/og.jpg', 'fake og image');

        $post = BlogPost::create([
            'title'     => ['az' => 'Test', 'en' => 'Test', 'ru' => 'Test'],
            'slug'      => ['az' => 'test-og', 'en' => 'test-og', 'ru' => 'test-og'],
            'og_image'  => 'blog/og.jpg',
            'is_active' => true,
        ]);

        $post->delete();

        Storage::disk('public')->assertMissing('blog/og.jpg');
    }

    public function test_multiple_single_fields_all_deleted(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('blog/cover.jpg', 'fake');
        Storage::disk('public')->put('blog/og.jpg', 'fake');

        $post = BlogPost::create([
            'title'       => ['az' => 'Test', 'en' => 'Test', 'ru' => 'Test'],
            'slug'        => ['az' => 'test-multi', 'en' => 'test-multi', 'ru' => 'test-multi'],
            'cover_image' => 'blog/cover.jpg',
            'og_image'    => 'blog/og.jpg',
            'is_active'   => true,
        ]);

        $post->delete();

        Storage::disk('public')->assertMissing('blog/cover.jpg');
        Storage::disk('public')->assertMissing('blog/og.jpg');
    }

    public function test_gallery_array_files_all_deleted_on_model_delete(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('portfolio/img1.jpg', 'fake');
        Storage::disk('public')->put('portfolio/img2.jpg', 'fake');
        Storage::disk('public')->put('portfolio/img3.jpg', 'fake');

        $item = PortfolioItem::create([
            'title'     => ['az' => 'Test', 'en' => 'Test', 'ru' => 'Test'],
            'slug'      => ['az' => 'test-gal', 'en' => 'test-gal', 'ru' => 'test-gal'],
            'gallery'   => ['portfolio/img1.jpg', 'portfolio/img2.jpg', 'portfolio/img3.jpg'],
            'is_active' => true,
        ]);

        $item->delete();

        Storage::disk('public')->assertMissing('portfolio/img1.jpg');
        Storage::disk('public')->assertMissing('portfolio/img2.jpg');
        Storage::disk('public')->assertMissing('portfolio/img3.jpg');
    }

    public function test_service_images_array_deleted_on_delete(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('services/img1.jpg', 'fake');
        Storage::disk('public')->put('services/img2.jpg', 'fake');

        $service = Service::create([
            'title'     => ['az' => 'Test', 'en' => 'Test', 'ru' => 'Test'],
            'slug'      => ['az' => 'test-svc', 'en' => 'test-svc', 'ru' => 'test-svc'],
            'images'    => ['services/img1.jpg', 'services/img2.jpg'],
            'is_active' => true,
        ]);

        $service->delete();

        Storage::disk('public')->assertMissing('services/img1.jpg');
        Storage::disk('public')->assertMissing('services/img2.jpg');
    }

    public function test_null_cover_image_does_not_throw_exception(): void
    {
        Storage::fake('public');

        $post = BlogPost::create([
            'title'       => ['az' => 'Test', 'en' => 'Test', 'ru' => 'Test'],
            'slug'        => ['az' => 'test-null', 'en' => 'test-null', 'ru' => 'test-null'],
            'cover_image' => null,
            'is_active'   => true,
        ]);

        // Must not throw any exception
        $post->delete();

        $this->assertDatabaseMissing('blog_posts', ['id' => $post->id]);
    }

    public function test_null_gallery_does_not_throw_exception(): void
    {
        Storage::fake('public');

        $item = PortfolioItem::create([
            'title'     => ['az' => 'Test', 'en' => 'Test', 'ru' => 'Test'],
            'slug'      => ['az' => 'test-null-gal', 'en' => 'test-null-gal', 'ru' => 'test-null-gal'],
            'gallery'   => null,
            'is_active' => true,
        ]);

        $item->delete();

        $this->assertDatabaseMissing('portfolio_items', ['id' => $item->id]);
    }

    public function test_model_is_removed_from_database_after_delete(): void
    {
        Storage::fake('public');

        $post = BlogPost::create([
            'title'     => ['az' => 'Silinəcək', 'en' => 'To Delete', 'ru' => 'Удалить'],
            'slug'      => ['az' => 'silinecek', 'en' => 'to-delete', 'ru' => 'udalit'],
            'is_active' => true,
        ]);

        $id = $post->id;
        $post->delete();

        $this->assertDatabaseMissing('blog_posts', ['id' => $id]);
    }
}

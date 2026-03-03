<?php

namespace Tests\Feature\Frontend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    // ──────────────────────────────────────────
    // Static pages
    // ──────────────────────────────────────────

    public function test_about_page_returns_200(): void
    {
        $this->get('/az/haqqimizda')->assertStatus(200);
    }

    public function test_about_page_returns_200_for_en(): void
    {
        $this->get('/en/haqqimizda')->assertStatus(200);
    }

    public function test_about_page_returns_200_for_ru(): void
    {
        $this->get('/ru/haqqimizda')->assertStatus(200);
    }

    public function test_contact_page_returns_200(): void
    {
        $this->get('/az/elaqe')->assertStatus(200);
    }

    public function test_contact_page_returns_200_for_en(): void
    {
        $this->get('/en/elaqe')->assertStatus(200);
    }

    public function test_privacy_page_returns_200(): void
    {
        $this->get('/az/mexfilik')->assertStatus(200);
    }

    public function test_privacy_page_returns_200_for_en(): void
    {
        $this->get('/en/mexfilik')->assertStatus(200);
    }

    // ──────────────────────────────────────────
    // Contact form validation
    // ──────────────────────────────────────────

    public function test_contact_post_fails_without_any_fields(): void
    {
        $this->post('/az/elaqe', [])
            ->assertSessionHasErrors(['name', 'phone']);
    }

    public function test_contact_post_fails_without_name(): void
    {
        $this->post('/az/elaqe', ['phone' => '+994501234567'])
            ->assertSessionHasErrors(['name'])
            ->assertSessionDoesntHaveErrors(['phone']);
    }

    public function test_contact_post_fails_without_phone(): void
    {
        $this->post('/az/elaqe', ['name' => 'Elgun'])
            ->assertSessionHasErrors(['phone'])
            ->assertSessionDoesntHaveErrors(['name']);
    }

    public function test_contact_post_fails_if_name_too_long(): void
    {
        $this->post('/az/elaqe', [
            'name'  => str_repeat('A', 101),
            'phone' => '+994501234567',
        ])->assertSessionHasErrors(['name']);
    }

    public function test_contact_post_fails_if_phone_too_long(): void
    {
        $this->post('/az/elaqe', [
            'name'  => 'Test',
            'phone' => str_repeat('1', 21),
        ])->assertSessionHasErrors(['phone']);
    }

    public function test_contact_post_succeeds_with_name_and_phone(): void
    {
        $this->post('/az/elaqe', [
            'name'  => 'Elgun Həsənov',
            'phone' => '+994501234567',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');
    }

    public function test_contact_post_succeeds_with_optional_message(): void
    {
        $this->post('/az/elaqe', [
            'name'    => 'Elgun',
            'phone'   => '+994501234567',
            'message' => 'Salam, məlumat almaq istəyirəm.',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');
    }

    public function test_contact_post_saves_to_database(): void
    {
        $this->post('/az/elaqe', [
            'name'    => 'Test İstifadəçi',
            'phone'   => '+994771234567',
            'message' => 'Test mesaj',
        ]);

        $this->assertDatabaseHas('contact_messages', [
            'name'    => 'Test İstifadəçi',
            'phone'   => '+994771234567',
            'message' => 'Test mesaj',
        ]);
    }

    public function test_contact_post_fails_with_invalid_service_id(): void
    {
        $this->post('/az/elaqe', [
            'name'       => 'Test',
            'phone'      => '+994501234567',
            'service_id' => 99999, // Nonexistent ID
        ])->assertSessionHasErrors(['service_id']);
    }

    // ──────────────────────────────────────────
    // SEO files
    // ──────────────────────────────────────────

    public function test_robots_txt_returns_200_with_plain_text_content_type(): void
    {
        $this->get('/robots.txt')
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function test_robots_txt_contains_user_agent(): void
    {
        $this->get('/robots.txt')->assertSee('User-agent');
    }

    public function test_sitemap_xml_returns_200(): void
    {
        $this->get('/sitemap.xml')->assertStatus(200);
    }

    public function test_sitemap_xml_contains_xml_declaration(): void
    {
        $response = $this->get('/sitemap.xml');
        $this->assertStringContainsString('<?xml', $response->getContent());
    }

    // ──────────────────────────────────────────
    // All locales test
    // ──────────────────────────────────────────

    public function test_all_static_pages_accessible_in_all_locales(): void
    {
        $pages   = ['haqqimizda', 'elaqe', 'mexfilik'];
        $locales = ['az', 'en', 'ru'];

        foreach ($locales as $locale) {
            foreach ($pages as $page) {
                $this->get("/{$locale}/{$page}")
                    ->assertStatus(200, "Failed: /{$locale}/{$page} did not return 200");
            }
        }
    }
}

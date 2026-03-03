<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(string $email = 'admin@166usta.az', string $password = 'secret123'): Admin
    {
        return Admin::create([
            'name'     => 'Test Admin',
            'email'    => $email,
            'password' => Hash::make($password),
        ]);
    }

    // ──────────────────────────────────────────
    // Login page
    // ──────────────────────────────────────────

    public function test_login_page_returns_200(): void
    {
        $this->get('/admin/login')->assertStatus(200);
    }

    public function test_login_page_contains_form(): void
    {
        $this->get('/admin/login')
            ->assertSee('email', false)
            ->assertSee('password', false);
    }

    // ──────────────────────────────────────────
    // Login POST
    // ──────────────────────────────────────────

    public function test_admin_can_login_with_correct_credentials(): void
    {
        $this->createAdmin('admin@166usta.az', 'secret123');

        $this->post('/admin/login', [
            'email'    => 'admin@166usta.az',
            'password' => 'secret123',
        ])->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_is_authenticated_after_login(): void
    {
        $this->createAdmin('admin@166usta.az', 'secret123');

        $this->post('/admin/login', [
            'email'    => 'admin@166usta.az',
            'password' => 'secret123',
        ]);

        $this->assertAuthenticated('admin');
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $this->createAdmin('admin@166usta.az', 'correct_password');

        $this->post('/admin/login', [
            'email'    => 'admin@166usta.az',
            'password' => 'wrong_password',
        ])
        ->assertRedirect()
        ->assertSessionHasErrors(['email']);
    }

    public function test_login_fails_with_nonexistent_email(): void
    {
        $this->post('/admin/login', [
            'email'    => 'nobody@example.com',
            'password' => 'password',
        ])->assertSessionHasErrors(['email']);
    }

    public function test_login_requires_email_field(): void
    {
        $this->post('/admin/login', ['password' => 'secret'])
            ->assertSessionHasErrors(['email']);
    }

    public function test_login_requires_password_field(): void
    {
        $this->post('/admin/login', ['email' => 'admin@test.com'])
            ->assertSessionHasErrors(['password']);
    }

    public function test_login_fails_with_invalid_email_format(): void
    {
        $this->post('/admin/login', [
            'email'    => 'not-an-email',
            'password' => 'secret',
        ])->assertSessionHasErrors(['email']);
    }

    public function test_login_fails_with_empty_credentials(): void
    {
        $this->post('/admin/login', [])
            ->assertSessionHasErrors(['email', 'password']);
    }

    // ──────────────────────────────────────────
    // Admin middleware protection
    // ──────────────────────────────────────────

    public function test_dashboard_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_services_list_requires_authentication(): void
    {
        $this->get('/admin/services')->assertRedirect(route('admin.login'));
    }

    public function test_blog_list_requires_authentication(): void
    {
        $this->get('/admin/blog')->assertRedirect(route('admin.login'));
    }

    public function test_portfolio_list_requires_authentication(): void
    {
        $this->get('/admin/portfolio')->assertRedirect(route('admin.login'));
    }

    public function test_settings_requires_authentication(): void
    {
        $this->get('/admin/settings')->assertRedirect(route('admin.login'));
    }

    public function test_boxes_list_requires_authentication(): void
    {
        $this->get('/admin/boxes')->assertRedirect(route('admin.login'));
    }

    public function test_campaigns_list_requires_authentication(): void
    {
        $this->get('/admin/campaigns')->assertRedirect(route('admin.login'));
    }

    // ──────────────────────────────────────────
    // Authenticated admin access
    // ──────────────────────────────────────────

    public function test_authenticated_admin_can_access_dashboard(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get('/admin')
            ->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_services(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get('/admin/services')
            ->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_blog(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get('/admin/blog')
            ->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_portfolio(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get('/admin/portfolio')
            ->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_boxes(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get('/admin/boxes')
            ->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_campaigns(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get('/admin/campaigns')
            ->assertStatus(200);
    }

    public function test_authenticated_admin_can_access_settings(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get('/admin/settings')
            ->assertStatus(200);
    }

    // ──────────────────────────────────────────
    // Logout
    // ──────────────────────────────────────────

    public function test_admin_can_logout(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->post('/admin/logout')
            ->assertRedirect(route('admin.login'));
    }

    public function test_after_logout_admin_is_not_authenticated(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin');
        $this->post('/admin/logout');

        $this->assertGuest('admin');
    }

    public function test_after_logout_dashboard_redirects_to_login(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin');
        $this->post('/admin/logout');

        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    // ──────────────────────────────────────────
    // Already logged in behaviour
    // ──────────────────────────────────────────

    public function test_logged_in_admin_is_redirected_from_login_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get('/admin/login')
            ->assertRedirect(route('admin.dashboard'));
    }
}

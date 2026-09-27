<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_from_the_dashboard(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/admin/login');
    }

    public function test_guests_are_redirected_from_product_management(): void
    {
        $this->get('/admin/products')->assertRedirect('/admin/login');
    }

    public function test_a_user_without_the_admin_role_is_forbidden(): void
    {
        // Exercises EnsureUserIsAdmin specifically — 'auth' alone would let this through.
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer)->get('/admin/dashboard')->assertForbidden();
    }

    public function test_an_admin_can_log_in_and_reach_the_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'password' => 'a-secure-test-password']);

        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'a-secure-test-password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_login_fails_with_the_wrong_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'password' => 'a-secure-test-password']);

        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'the-wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_logout_actually_ends_the_session(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post('/admin/logout');

        $this->assertGuest();
    }
}

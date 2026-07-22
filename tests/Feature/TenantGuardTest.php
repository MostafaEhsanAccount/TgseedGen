<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantGuardTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_whose_tenant_is_suspended_is_logged_out(): void
    {
        $tenant = Tenant::factory()->create(['is_active' => false]);
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_a_user_with_an_active_tenant_is_not_affected(): void
    {
        $tenant = Tenant::factory()->create(['is_active' => true]);
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $this->assertAuthenticated();
    }

    public function test_a_super_admin_without_a_tenant_is_not_logged_out(): void
    {
        $admin = User::factory()->superAdmin()->create();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertOk();
        $this->assertAuthenticated();
    }
}

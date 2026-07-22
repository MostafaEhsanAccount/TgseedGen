<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuperAdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_super_admin_can_view_the_admin_dashboard(): void
    {
        $admin = User::factory()->superAdmin()->create();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertOk();
        $response->assertSee('لوحة تحكم المنصة');
    }

    public function test_a_regular_tenant_owner_cannot_view_the_admin_dashboard(): void
    {
        $tenant = Tenant::factory()->create();
        $owner = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'owner']);

        $response = $this->actingAs($owner)->get('/admin/dashboard');

        $response->assertForbidden();
    }

    public function test_a_guest_is_redirected_to_login_instead_of_the_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect(route('login'));
    }
}

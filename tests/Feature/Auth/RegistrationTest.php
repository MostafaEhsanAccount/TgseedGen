<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'company' => 'Acme Inc',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_registration_creates_a_tenant_and_makes_the_user_its_owner(): void
    {
        $this->post('/register', [
            'company' => 'Acme Inc',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = \App\Models\User::withoutGlobalScopes()->where('email', 'test@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('owner', $user->role);
        $this->assertNotNull($user->tenant_id);

        $tenant = \App\Models\Tenant::find($user->tenant_id);
        $this->assertSame('Acme Inc', $tenant->name);
        $this->assertSame($user->id, $tenant->owner_user_id);
        $this->assertTrue($tenant->is_active);
    }

    public function test_company_name_is_required_to_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('company');
        $this->assertGuest();
    }
}

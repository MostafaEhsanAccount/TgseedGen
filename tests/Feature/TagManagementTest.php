<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_view_the_tags_page(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        $this->actingAs($user)->get(route('tags.index'))->assertOk();
    }

    public function test_a_user_can_create_a_tag(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        $this->actingAs($user)->post(route('tags.store'), [
            'name' => 'VIP',
            'color' => '#4f46e5',
        ])->assertRedirect(route('tags.index'));

        $tag = Tag::first();
        $this->assertSame('VIP', $tag->name);
        $this->assertSame($tenant->id, $tag->tenant_id);
    }

    public function test_tags_are_isolated_between_tenants(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();
        $userA = User::factory()->create(['tenant_id' => $tenantA->id]);
        Tag::factory()->create(['tenant_id' => $tenantB->id]);

        $this->actingAs($userA);

        $this->assertSame(0, Tag::count());
    }
}

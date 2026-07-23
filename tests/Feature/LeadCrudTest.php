<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadCrudTest extends TestCase
{
    use RefreshDatabase;

    private function firstStage(Tenant $tenant)
    {
        return $tenant->pipelineStages()->orderBy('order')->first();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/leads')->assertRedirect('/login');
    }

    public function test_index_page_loads_successfully(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        $this->actingAs($user)->get('/leads')->assertOk();
    }

    public function test_board_page_loads_successfully(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        $this->actingAs($user)->get('/leads/board')->assertOk();
    }

    public function test_a_user_can_create_a_lead(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $stage = $this->firstStage($tenant);

        $response = $this->actingAs($user)->post('/leads', [
            'name' => 'Ahmed Test',
            'company' => 'Acme',
            'pipeline_stage_id' => $stage->id,
        ]);

        $lead = Lead::first();
        $response->assertRedirect(route('leads.show', $lead));
        $this->assertSame('Ahmed Test', $lead->name);
        $this->assertSame($tenant->id, $lead->tenant_id);
        $this->assertSame($user->id, $lead->created_by);
    }

    public function test_creating_a_lead_without_a_name_fails_validation(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $stage = $this->firstStage($tenant);

        $this->actingAs($user)->post('/leads', [
            'pipeline_stage_id' => $stage->id,
        ])->assertSessionHasErrors('name');

        $this->assertSame(0, Lead::count());
    }

    public function test_a_user_can_view_a_leads_show_page(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $lead = Lead::factory()->create([
            'tenant_id' => $tenant->id,
            'pipeline_stage_id' => $this->firstStage($tenant)->id,
            'created_by' => $user->id,
        ]);

        $this->actingAs($user)->get(route('leads.show', $lead))
            ->assertOk()
            ->assertSee($lead->name);
    }

    public function test_a_lead_from_another_tenant_returns_404(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();
        $userA = User::factory()->create(['tenant_id' => $tenantA->id]);
        $leadB = Lead::factory()->create([
            'tenant_id' => $tenantB->id,
            'pipeline_stage_id' => $this->firstStage($tenantB)->id,
            'created_by' => User::factory()->create(['tenant_id' => $tenantB->id])->id,
        ]);

        $this->actingAs($userA)->get('/leads/'.$leadB->id)->assertNotFound();
    }

    public function test_a_user_can_update_a_lead(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $stage = $this->firstStage($tenant);
        $lead = Lead::factory()->create([
            'tenant_id' => $tenant->id,
            'pipeline_stage_id' => $stage->id,
            'created_by' => $user->id,
        ]);

        $this->actingAs($user)->put(route('leads.update', $lead), [
            'name' => 'Updated Name',
            'pipeline_stage_id' => $stage->id,
        ])->assertRedirect(route('leads.show', $lead));

        $this->assertSame('Updated Name', $lead->fresh()->name);
    }

    public function test_a_user_can_delete_a_lead(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $lead = Lead::factory()->create([
            'tenant_id' => $tenant->id,
            'pipeline_stage_id' => $this->firstStage($tenant)->id,
            'created_by' => $user->id,
        ]);

        $this->actingAs($user)->delete(route('leads.destroy', $lead))
            ->assertRedirect(route('leads.index'));

        $this->assertSoftDeleted($lead);
    }
}

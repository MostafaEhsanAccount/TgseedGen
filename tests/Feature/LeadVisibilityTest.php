<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadVisibilityTest extends TestCase
{
    use RefreshDatabase;

    private function firstStage(Tenant $tenant)
    {
        return $tenant->pipelineStages()->orderBy('order')->first();
    }

    public function test_leads_are_isolated_between_tenants(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();
        $ownerA = User::factory()->create(['tenant_id' => $tenantA->id, 'role' => 'owner']);

        Lead::factory()->create([
            'tenant_id' => $tenantA->id,
            'pipeline_stage_id' => $this->firstStage($tenantA)->id,
            'created_by' => $ownerA->id,
        ]);
        Lead::factory()->create([
            'tenant_id' => $tenantB->id,
            'pipeline_stage_id' => $this->firstStage($tenantB)->id,
            'created_by' => User::factory()->create(['tenant_id' => $tenantB->id])->id,
        ]);

        $this->actingAs($ownerA);
        $leads = Lead::all();

        $this->assertCount(1, $leads);
        $this->assertSame($tenantA->id, $leads->first()->tenant_id);
    }

    public function test_agent_only_sees_leads_assigned_to_them(): void
    {
        $tenant = Tenant::factory()->create();
        $owner = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'owner']);
        $agent1 = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'agent']);
        $agent2 = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'agent']);
        $stage = $this->firstStage($tenant);

        Lead::factory()->create([
            'tenant_id' => $tenant->id, 'pipeline_stage_id' => $stage->id,
            'created_by' => $owner->id, 'assigned_user_id' => $agent1->id,
        ]);
        Lead::factory()->create([
            'tenant_id' => $tenant->id, 'pipeline_stage_id' => $stage->id,
            'created_by' => $owner->id, 'assigned_user_id' => $agent2->id,
        ]);
        Lead::factory()->create([
            'tenant_id' => $tenant->id, 'pipeline_stage_id' => $stage->id,
            'created_by' => $owner->id, 'assigned_user_id' => null,
        ]);

        $this->actingAs($agent1);
        $this->assertCount(1, Lead::all());
        $this->assertSame($agent1->id, Lead::all()->first()->assigned_user_id);

        $this->actingAs($owner);
        $this->assertCount(3, Lead::all());
    }

    public function test_agent_cannot_view_or_update_a_lead_not_assigned_to_them(): void
    {
        $tenant = Tenant::factory()->create();
        $owner = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'owner']);
        $agent = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'agent']);
        $otherAgent = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'agent']);
        $stage = $this->firstStage($tenant);

        $othersLead = Lead::factory()->create([
            'tenant_id' => $tenant->id, 'pipeline_stage_id' => $stage->id,
            'created_by' => $owner->id, 'assigned_user_id' => $otherAgent->id,
        ]);
        $ownLead = Lead::factory()->create([
            'tenant_id' => $tenant->id, 'pipeline_stage_id' => $stage->id,
            'created_by' => $owner->id, 'assigned_user_id' => $agent->id,
        ]);

        $this->assertFalse($agent->can('view', $othersLead));
        $this->assertFalse($agent->can('update', $othersLead));
        $this->assertTrue($agent->can('view', $ownLead));
        $this->assertTrue($agent->can('update', $ownLead));
        $this->assertTrue($owner->can('view', $othersLead));
        $this->assertTrue($owner->can('update', $othersLead));
    }
}

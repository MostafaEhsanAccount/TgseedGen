<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LeadKanbanTest extends TestCase
{
    use RefreshDatabase;

    public function test_board_groups_leads_by_stage(): void
    {
        $tenant = Tenant::factory()->create();
        $owner = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'owner']);
        $stages = $tenant->pipelineStages()->orderBy('order')->get();

        Lead::factory()->create([
            'tenant_id' => $tenant->id,
            'pipeline_stage_id' => $stages[0]->id,
            'created_by' => $owner->id,
            'name' => 'Board Lead One',
        ]);

        $this->actingAs($owner);

        Livewire::test('lead-board')
            ->assertSee('Board Lead One')
            ->assertSee($stages[0]->name);
    }

    public function test_moving_a_lead_updates_its_stage(): void
    {
        $tenant = Tenant::factory()->create();
        $owner = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'owner']);
        $stages = $tenant->pipelineStages()->orderBy('order')->get();

        $lead = Lead::factory()->create([
            'tenant_id' => $tenant->id,
            'pipeline_stage_id' => $stages[0]->id,
            'created_by' => $owner->id,
        ]);

        $this->actingAs($owner);

        Livewire::test('lead-board')
            ->call('moveLead', $lead->id, $stages[1]->id);

        $this->assertSame($stages[1]->id, $lead->fresh()->pipeline_stage_id);
    }

    public function test_an_agent_cannot_move_a_lead_not_assigned_to_them(): void
    {
        // The agent-visibility scope on the Lead model hides other agents'
        // leads from every query (including findOrFail inside moveLead), so
        // this fails closed with a 404-equivalent before the Policy even runs.
        $tenant = Tenant::factory()->create();
        $owner = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'owner']);
        $agent = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'agent']);
        $otherAgent = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'agent']);
        $stages = $tenant->pipelineStages()->orderBy('order')->get();

        $lead = Lead::factory()->create([
            'tenant_id' => $tenant->id,
            'pipeline_stage_id' => $stages[0]->id,
            'created_by' => $owner->id,
            'assigned_user_id' => $otherAgent->id,
        ]);

        $this->actingAs($agent);

        $this->expectException(ModelNotFoundException::class);

        Livewire::test('lead-board')
            ->call('moveLead', $lead->id, $stages[1]->id);
    }
}

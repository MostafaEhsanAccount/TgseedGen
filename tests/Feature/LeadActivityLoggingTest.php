<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadActivityLoggingTest extends TestCase
{
    use RefreshDatabase;

    public function test_changing_the_pipeline_stage_logs_a_status_change_activity(): void
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
        $lead->update(['pipeline_stage_id' => $stages[1]->id]);

        $this->assertCount(1, $lead->activities);
        $activity = $lead->activities->first();
        $this->assertSame('status_change', $activity->type);
        $this->assertSame($stages[0]->id, $activity->meta['from']);
        $this->assertSame($stages[1]->id, $activity->meta['to']);
    }

    public function test_updating_an_unrelated_field_does_not_log_a_status_change(): void
    {
        $tenant = Tenant::factory()->create();
        $owner = User::factory()->create(['tenant_id' => $tenant->id, 'role' => 'owner']);
        $stage = $tenant->pipelineStages()->orderBy('order')->first();

        $lead = Lead::factory()->create([
            'tenant_id' => $tenant->id,
            'pipeline_stage_id' => $stage->id,
            'created_by' => $owner->id,
        ]);

        $this->actingAs($owner);
        $lead->update(['notes' => 'تم الاتصال وتم الاتفاق على موعد']);

        $this->assertCount(0, $lead->activities()->get());
    }
}

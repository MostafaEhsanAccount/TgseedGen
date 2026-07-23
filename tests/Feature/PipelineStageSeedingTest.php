<?php

namespace Tests\Feature;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PipelineStageSeedingTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_tenant_seeds_five_default_pipeline_stages(): void
    {
        $tenant = Tenant::factory()->create();

        $this->assertCount(5, $tenant->pipelineStages()->orderBy('order')->get());
    }

    public function test_default_stages_have_the_expected_slugs_and_order(): void
    {
        $tenant = Tenant::factory()->create();

        $slugs = $tenant->pipelineStages()->orderBy('order')->pluck('slug')->all();

        $this->assertSame(['new', 'contacted', 'interested', 'won', 'lost'], $slugs);
    }

    public function test_only_the_won_and_lost_stages_are_marked_closed(): void
    {
        $tenant = Tenant::factory()->create();

        $stages = $tenant->pipelineStages()->orderBy('order')->get()->keyBy('slug');

        $this->assertFalse($stages['new']->is_closed_won);
        $this->assertFalse($stages['new']->is_closed_lost);
        $this->assertTrue($stages['won']->is_closed_won);
        $this->assertFalse($stages['won']->is_closed_lost);
        $this->assertTrue($stages['lost']->is_closed_lost);
        $this->assertFalse($stages['lost']->is_closed_won);
    }

    public function test_two_tenants_do_not_share_pipeline_stage_rows(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $this->assertCount(5, $tenantA->pipelineStages()->get());
        $this->assertCount(5, $tenantB->pipelineStages()->get());
        $this->assertNotEquals(
            $tenantA->pipelineStages()->pluck('id'),
            $tenantB->pipelineStages()->pluck('id'),
        );
    }
}

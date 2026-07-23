<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadNotesAndRemindersTest extends TestCase
{
    use RefreshDatabase;

    private function makeLead(Tenant $tenant, User $user)
    {
        return Lead::factory()->create([
            'tenant_id' => $tenant->id,
            'pipeline_stage_id' => $tenant->pipelineStages()->orderBy('order')->first()->id,
            'created_by' => $user->id,
        ]);
    }

    public function test_a_user_can_add_a_note_to_a_lead(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $lead = $this->makeLead($tenant, $user);

        $this->actingAs($user)->post(route('leads.notes.store', $lead), [
            'body' => 'تم التواصل هاتفيًا',
        ])->assertRedirect(route('leads.show', $lead));

        $this->assertSame(1, $lead->activities()->where('type', 'note')->count());
        $this->assertSame('تم التواصل هاتفيًا', $lead->activities()->where('type', 'note')->first()->body);
    }

    public function test_a_user_can_add_and_mark_a_reminder_done(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $lead = $this->makeLead($tenant, $user);

        $this->actingAs($user)->post(route('leads.reminders.store', $lead), [
            'remind_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'note' => 'Follow up call',
        ])->assertRedirect(route('leads.show', $lead));

        $reminder = $lead->reminders()->first();
        $this->assertNotNull($reminder);
        $this->assertFalse($reminder->is_done);

        $this->actingAs($user)->patch(route('reminders.markDone', $reminder))
            ->assertRedirect(route('leads.show', $lead));

        $this->assertTrue($reminder->fresh()->is_done);
        $this->assertNotNull($reminder->fresh()->done_at);
    }
}

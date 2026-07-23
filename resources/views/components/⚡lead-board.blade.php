<?php

use App\Models\Lead;
use App\Models\PipelineStage;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

new class extends Component
{
    public function moveLead(int $leadId, int $stageId): void
    {
        $lead = Lead::findOrFail($leadId);

        Gate::authorize('update', $lead);

        $stage = PipelineStage::findOrFail($stageId);

        $lead->update(['pipeline_stage_id' => $stage->id]);
    }

    public function with(): array
    {
        return [
            'stages' => PipelineStage::orderBy('order')
                ->with(['leads' => fn ($query) => $query->with('assignee')->latest()])
                ->get(),
        ];
    }
};
?>

<div class="row g-3 flex-nowrap overflow-x-auto pb-2">
    @foreach ($stages as $stage)
        <div class="col-3" style="min-width: 260px;" wire:key="stage-{{ $stage->id }}">
            <div
                class="card h-100"
                x-on:dragover.prevent
                x-on:drop.prevent="$wire.moveLead($event.dataTransfer.getData('leadId'), {{ $stage->id }})"
            >
                <div class="card-header" style="border-top: 3px solid {{ $stage->color }}">
                    <h3 class="card-title">{{ $stage->name }}</h3>
                    <span class="badge bg-secondary-lt ms-auto">{{ $stage->leads->count() }}</span>
                </div>
                <div class="card-body d-flex flex-column gap-2" style="min-height: 200px;">
                    @foreach ($stage->leads as $lead)
                        <div
                            class="card card-sm"
                            draggable="true"
                            x-on:dragstart="$event.dataTransfer.setData('leadId', '{{ $lead->id }}')"
                            wire:key="lead-{{ $lead->id }}"
                        >
                            <div class="card-body">
                                <a href="{{ route('leads.show', $lead) }}" class="fw-bold text-body">{{ $lead->name }}</a>
                                <div class="text-secondary small">{{ $lead->company }}</div>
                                <div class="text-secondary small">{{ $lead->assignee?->name ?? __('leads.unassigned') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>

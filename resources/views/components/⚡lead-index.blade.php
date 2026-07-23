<?php

use App\Models\Lead;
use App\Models\PipelineStage;
use App\Models\Tag;
use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $stage = '';

    #[Url]
    public string $tag = '';

    #[Url]
    public string $assignee = '';

    public function updating(): void
    {
        $this->resetPage();
    }

    public function with(): array
    {
        $leads = Lead::query()
            ->with(['stage', 'assignee', 'tags'])
            ->when($this->search !== '', fn ($query) => $query->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('company', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            }))
            ->when($this->stage !== '', fn ($query) => $query->where('pipeline_stage_id', $this->stage))
            ->when($this->tag !== '', fn ($query) => $query->whereHas('tags', fn ($query) => $query->where('tags.id', $this->tag)))
            ->when($this->assignee !== '', fn ($query) => $query->where('assigned_user_id', $this->assignee))
            ->latest()
            ->paginate(15);

        return [
            'leads' => $leads,
            'stages' => PipelineStage::orderBy('order')->get(),
            'tags' => Tag::orderBy('name')->get(),
            'users' => User::where('tenant_id', auth()->user()->tenant_id)->orderBy('name')->get(),
        ];
    }
};
?>

<div>
    <div class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="search" wire:model.live.debounce.400ms="search" class="form-control" placeholder="{{ __('leads.search_placeholder') }}">
        </div>
        <div class="col-md-2">
            <select wire:model.live="stage" class="form-select">
                <option value="">{{ __('leads.all_stages') }}</option>
                @foreach ($stages as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="tag" class="form-select">
                <option value="">{{ __('leads.all_tags') }}</option>
                @foreach ($tags as $t)
                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="assignee" class="form-select">
                <option value="">{{ __('leads.all_assignees') }}</option>
                @foreach ($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 text-end">
            <a href="{{ route('leads.create') }}" class="btn btn-primary w-100">{{ __('leads.new_lead') }}</a>
        </div>
    </div>

    <div class="row g-2 mb-3 justify-content-end">
        <div class="col-auto">
            <a href="{{ route('leads.export', ['search' => $search, 'stage' => $stage, 'tag' => $tag, 'assignee' => $assignee]) }}" class="btn btn-outline-secondary">{{ __('leads.export') }}</a>
        </div>
        <div class="col-auto">
            <a href="{{ route('leads.import.create') }}" class="btn btn-outline-secondary">{{ __('leads.import') }}</a>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>{{ __('leads.name') }}</th>
                        <th>{{ __('leads.company') }}</th>
                        <th>{{ __('leads.phone') }}</th>
                        <th>{{ __('leads.stage') }}</th>
                        <th>{{ __('leads.assignee') }}</th>
                        <th>{{ __('leads.tags') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leads as $lead)
                        <tr wire:key="lead-{{ $lead->id }}">
                            <td><a href="{{ route('leads.show', $lead) }}">{{ $lead->name }}</a></td>
                            <td>{{ $lead->company }}</td>
                            <td>{{ $lead->phone }}</td>
                            <td><span class="badge" style="background-color: {{ $lead->stage->color }}">{{ $lead->stage->name }}</span></td>
                            <td>{{ $lead->assignee?->name ?? '—' }}</td>
                            <td>
                                @foreach ($lead->tags as $tag)
                                    <span class="badge bg-secondary-lt">{{ $tag->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-4">{{ __('leads.no_matching_leads') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $leads->links() }}
        </div>
    </div>
</div>

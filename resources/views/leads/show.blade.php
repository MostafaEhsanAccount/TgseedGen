<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center">
            <h2 class="page-title">{{ $lead->name }}</h2>
            <div class="ms-auto btn-list">
                <a href="{{ route('leads.edit', $lead) }}" class="btn btn-outline-primary">{{ __('leads.edit') }}</a>
                <form method="POST" action="{{ route('leads.destroy', $lead) }}" onsubmit="return confirm('{{ __('leads.confirm_delete') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">{{ __('leads.delete') }}</button>
                </form>
            </div>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">{{ __('leads.lead_details') }}</h3>
                    <div class="mb-2"><span class="badge" style="background-color: {{ $lead->stage->color }}">{{ $lead->stage->name }}</span></div>
                    <dl class="row">
                        <dt class="col-5">{{ __('leads.company') }}</dt><dd class="col-7">{{ $lead->company ?? '—' }}</dd>
                        <dt class="col-5">{{ __('leads.phone') }}</dt><dd class="col-7">{{ $lead->phone ?? '—' }}</dd>
                        <dt class="col-5">{{ __('leads.email') }}</dt><dd class="col-7">{{ $lead->email ?? '—' }}</dd>
                        <dt class="col-5">{{ __('leads.website') }}</dt><dd class="col-7">{{ $lead->website ?? '—' }}</dd>
                        <dt class="col-5">{{ __('leads.industry') }}</dt><dd class="col-7">{{ $lead->industry ?? '—' }}</dd>
                        <dt class="col-5">{{ __('leads.city') }}</dt><dd class="col-7">{{ $lead->city ?? '—' }}</dd>
                        <dt class="col-5">{{ __('leads.country') }}</dt><dd class="col-7">{{ $lead->country ?? '—' }}</dd>
                        <dt class="col-5">{{ __('leads.assignee') }}</dt><dd class="col-7">{{ $lead->assignee?->name ?? __('leads.unassigned') }}</dd>
                    </dl>
                    <div class="d-flex flex-wrap gap-1">
                        @foreach ($lead->tags as $tag)
                            <span class="badge bg-secondary-lt">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    @if ($lead->notes)
                        <hr>
                        <p class="text-secondary">{{ $lead->notes }}</p>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header"><h3 class="card-title">{{ __('leads.reminders') }}</h3></div>
                <div class="list-group list-group-flush">
                    @forelse ($lead->reminders as $reminder)
                        <div class="list-group-item d-flex align-items-center">
                            <div>
                                <div class="{{ $reminder->is_done ? 'text-decoration-line-through text-secondary' : '' }}">{{ $reminder->note }}</div>
                                <div class="small text-secondary">{{ $reminder->remind_at->format('Y-m-d H:i') }}</div>
                            </div>
                            @unless ($reminder->is_done)
                                <form method="POST" action="{{ route('reminders.markDone', $reminder) }}" class="ms-auto">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success">{{ __('leads.mark_done') }}</button>
                                </form>
                            @endunless
                        </div>
                    @empty
                        <div class="list-group-item text-secondary">{{ __('leads.no_reminders') }}</div>
                    @endforelse
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('leads.reminders.store', $lead) }}">
                        @csrf
                        <div class="mb-2">
                            <input type="datetime-local" name="remind_at" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <input type="text" name="note" class="form-control" placeholder="{{ __('leads.reminder_note_placeholder') }}" required>
                        </div>
                        <button type="submit" class="btn btn-outline-primary btn-sm">{{ __('leads.add_reminder') }}</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3 class="card-title">{{ __('leads.timeline') }}</h3></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('leads.notes.store', $lead) }}" class="mb-4">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="body" class="form-control" placeholder="{{ __('leads.add_note_placeholder') }}" required>
                            <button type="submit" class="btn btn-primary">{{ __('leads.add') }}</button>
                        </div>
                    </form>

                    <div class="divide-y">
                        @forelse ($lead->activities as $activity)
                            <div class="py-2">
                                <div class="small text-secondary">{{ $activity->created_at->format('Y-m-d H:i') }} — {{ $activity->user?->name ?? __('leads.system') }}</div>
                                <div>{{ $activity->body }}</div>
                            </div>
                        @empty
                            <p class="text-secondary">{{ __('leads.no_activity_yet') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

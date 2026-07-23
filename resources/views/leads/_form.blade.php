@php
    $lead = $lead ?? null;
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label required">{{ __('leads.name') }}</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $lead?->name) }}">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">{{ __('leads.company') }}</label>
        <input type="text" name="company" class="form-control" value="{{ old('company', $lead?->company) }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">{{ __('leads.phone') }}</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $lead?->phone) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">{{ __('leads.email') }}</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $lead?->email) }}">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">{{ __('leads.website') }}</label>
        <input type="text" name="website" class="form-control" value="{{ old('website', $lead?->website) }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">{{ __('leads.industry') }}</label>
        <input type="text" name="industry" class="form-control" value="{{ old('industry', $lead?->industry) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">{{ __('leads.city') }}</label>
        <input type="text" name="city" class="form-control" value="{{ old('city', $lead?->city) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">{{ __('leads.country') }}</label>
        <input type="text" name="country" class="form-control" value="{{ old('country', $lead?->country) }}">
    </div>

    <div class="col-12">
        <label class="form-label">{{ __('leads.address') }}</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $lead?->address) }}">
    </div>

    <div class="col-md-6">
        <label class="form-label required">{{ __('leads.stage') }}</label>
        <select name="pipeline_stage_id" class="form-select @error('pipeline_stage_id') is-invalid @enderror">
            @foreach ($pipelineStages as $stage)
                <option value="{{ $stage->id }}" @selected(old('pipeline_stage_id', $lead?->pipeline_stage_id) == $stage->id)>{{ $stage->name }}</option>
            @endforeach
        </select>
        @error('pipeline_stage_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">{{ __('leads.assignee') }}</label>
        <select name="assigned_user_id" class="form-select">
            <option value="">{{ __('leads.unassigned') }}</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('assigned_user_id', $lead?->assigned_user_id) == $user->id)>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">{{ __('leads.tags') }}</label>
        <div class="d-flex flex-wrap gap-3">
            @foreach ($tags as $tag)
                <label class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="tags[]"
                        value="{{ $tag->id }}"
                        @checked(in_array($tag->id, old('tags', $lead?->tags->pluck('id')->all() ?? [])))
                    >
                    <span class="form-check-label">{{ $tag->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="col-12">
        <label class="form-label">{{ __('leads.notes') }}</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $lead?->notes) }}</textarea>
    </div>
</div>

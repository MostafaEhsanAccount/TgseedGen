<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Models\Lead;
use App\Models\PipelineStage;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(): View
    {
        return view('leads.index');
    }

    public function board(): View
    {
        return view('leads.board');
    }

    public function create(): View
    {
        return view('leads.create', $this->formOptions());
    }

    public function store(StoreLeadRequest $request): RedirectResponse
    {
        $lead = Lead::create($request->safe()->except('tags'));

        $lead->tags()->sync($request->safe()->input('tags', []));

        return redirect()->route('leads.show', $lead)
            ->with('status', __('leads.lead_created'));
    }

    public function show(Lead $lead): View
    {
        $this->authorize('view', $lead);

        $lead->load(['stage', 'assignee', 'tags', 'activities.user', 'reminders' => fn ($query) => $query->orderBy('remind_at')]);

        return view('leads.show', ['lead' => $lead]);
    }

    public function edit(Lead $lead): View
    {
        $this->authorize('update', $lead);

        return view('leads.edit', ['lead' => $lead, ...$this->formOptions()]);
    }

    public function update(UpdateLeadRequest $request, Lead $lead): RedirectResponse
    {
        $lead->update($request->safe()->except('tags'));

        $lead->tags()->sync($request->safe()->input('tags', []));

        return redirect()->route('leads.show', $lead)
            ->with('status', __('leads.lead_updated'));
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        $this->authorize('delete', $lead);

        $lead->delete();

        return redirect()->route('leads.index')
            ->with('status', __('leads.lead_deleted'));
    }

    /**
     * @return array<string, mixed>
     */
    private function formOptions(): array
    {
        return [
            'pipelineStages' => PipelineStage::orderBy('order')->get(),
            'users' => User::where('tenant_id', auth()->user()->tenant_id)->orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeadActivityController extends Controller
{
    public function store(Request $request, Lead $lead): RedirectResponse
    {
        $this->authorize('view', $lead);

        $request->validate([
            'body' => ['required', 'string'],
        ]);

        $lead->activities()->create([
            'user_id' => $request->user()->id,
            'type' => 'note',
            'body' => $request->input('body'),
        ]);

        return redirect()->route('leads.show', $lead)
            ->with('status', __('leads.note_added'));
    }
}

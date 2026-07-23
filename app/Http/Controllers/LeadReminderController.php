<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadReminder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeadReminderController extends Controller
{
    public function store(Request $request, Lead $lead): RedirectResponse
    {
        $this->authorize('view', $lead);

        $validated = $request->validate([
            'remind_at' => ['required', 'date'],
            'note' => ['required', 'string', 'max:255'],
        ]);

        $lead->reminders()->create([
            'user_id' => $request->user()->id,
            'remind_at' => $validated['remind_at'],
            'note' => $validated['note'],
        ]);

        return redirect()->route('leads.show', $lead)
            ->with('status', __('leads.reminder_added'));
    }

    public function markDone(LeadReminder $reminder): RedirectResponse
    {
        $this->authorize('update', $reminder->lead);

        $reminder->update([
            'is_done' => true,
            'done_at' => now(),
        ]);

        return redirect()->route('leads.show', $reminder->lead)
            ->with('status', __('leads.reminder_marked_done'));
    }
}

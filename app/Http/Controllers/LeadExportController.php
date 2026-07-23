<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadExportController extends Controller
{
    public function export(Request $request): StreamedResponse
    {
        $search = (string) $request->query('search', '');
        $stage = (string) $request->query('stage', '');
        $tag = (string) $request->query('tag', '');
        $assignee = (string) $request->query('assignee', '');

        $leads = Lead::query()
            ->with(['stage', 'assignee'])
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }))
            ->when($stage !== '', fn ($query) => $query->where('pipeline_stage_id', $stage))
            ->when($tag !== '', fn ($query) => $query->whereHas('tags', fn ($query) => $query->where('tags.id', $tag)))
            ->when($assignee !== '', fn ($query) => $query->where('assigned_user_id', $assignee))
            ->latest()
            ->get();

        return response()->streamDownload(function () use ($leads) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Name', 'Company', 'Phone', 'Email', 'Website', 'Industry', 'City', 'Country', 'Stage', 'Assignee']);

            foreach ($leads as $lead) {
                fputcsv($handle, [
                    $lead->name, $lead->company, $lead->phone, $lead->email, $lead->website,
                    $lead->industry, $lead->city, $lead->country,
                    $lead->stage->name, $lead->assignee?->name,
                ]);
            }

            fclose($handle);
        }, 'leads-'.now()->format('Y-m-d').'.csv');
    }
}

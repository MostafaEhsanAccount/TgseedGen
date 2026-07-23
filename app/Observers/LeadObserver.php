<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\LeadActivity;

class LeadObserver
{
    public function updating(Lead $lead): void
    {
        if ($lead->isDirty('pipeline_stage_id')) {
            LeadActivity::create([
                'lead_id' => $lead->id,
                'user_id' => auth()->id(),
                'type' => 'status_change',
                'body' => 'تم نقل العميل من مرحلة إلى أخرى',
                'meta' => [
                    'from' => $lead->getOriginal('pipeline_stage_id'),
                    'to' => $lead->pipeline_stage_id,
                ],
            ]);
        }
    }
}

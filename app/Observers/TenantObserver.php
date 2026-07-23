<?php

namespace App\Observers;

use App\Models\PipelineStage;
use App\Models\Tenant;

class TenantObserver
{
    /**
     * @var list<array{name: string, slug: string, color: string, is_closed_won?: bool, is_closed_lost?: bool}>
     */
    private const DEFAULT_STAGES = [
        ['name' => 'جديد', 'slug' => 'new', 'color' => '#8B7CF6'],
        ['name' => 'تواصل', 'slug' => 'contacted', 'color' => '#4C9AFF'],
        ['name' => 'مهتم', 'slug' => 'interested', 'color' => '#F5A623'],
        ['name' => 'عميل', 'slug' => 'won', 'color' => '#3FD68B', 'is_closed_won' => true],
        ['name' => 'مرفوض', 'slug' => 'lost', 'color' => '#F0605C', 'is_closed_lost' => true],
    ];

    public function created(Tenant $tenant): void
    {
        foreach (self::DEFAULT_STAGES as $order => $stage) {
            $tenant->pipelineStages()->create([...$stage, 'order' => $order]);
        }
    }
}

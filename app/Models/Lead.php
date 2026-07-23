<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use App\Observers\LeadObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'pipeline_stage_id', 'assigned_user_id', 'name', 'company', 'phone',
    'email', 'website', 'industry', 'address', 'city', 'country',
    'source', 'notes', 'created_by',
])]
#[ObservedBy(LeadObserver::class)]
class Lead extends Model
{
    use BelongsToTenant, HasFactory, SoftDeletes;

    protected static function booted(): void
    {
        static::addGlobalScope('visibility', function (Builder $query) {
            if (auth()->check() && auth()->user()->role === 'agent') {
                $query->where('assigned_user_id', auth()->id());
            }
        });

        static::creating(function (self $lead) {
            if (auth()->check() && empty($lead->created_by)) {
                $lead->created_by = auth()->id();
            }
        });
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(PipelineStage::class, 'pipeline_stage_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class)->latest();
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(LeadReminder::class);
    }
}

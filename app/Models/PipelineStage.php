<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'color', 'order', 'is_closed_won', 'is_closed_lost'])]
class PipelineStage extends Model
{
    use BelongsToTenant, HasFactory;

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_closed_won' => 'boolean',
            'is_closed_lost' => 'boolean',
        ];
    }
}

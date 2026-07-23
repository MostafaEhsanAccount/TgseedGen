<?php

namespace Database\Factories;

use App\Models\PipelineStage;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PipelineStage>
 */
class PipelineStageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => fake()->unique()->word(),
            'slug' => fake()->unique()->slug(1),
            'color' => fake()->hexColor(),
            'order' => 0,
            'is_closed_won' => false,
            'is_closed_lost' => false,
        ];
    }
}

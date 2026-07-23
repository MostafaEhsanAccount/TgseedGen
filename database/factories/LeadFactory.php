<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lead>
 *
 * Relational foreign keys (tenant_id, pipeline_stage_id, created_by) have no
 * defaults here — a Lead is meaningless without a real tenant/stage/creator,
 * so callers must supply them explicitly (e.g. from an already-seeded tenant).
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company' => fake()->company(),
            'phone' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'website' => fake()->domainName(),
            'industry' => fake()->word(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'source' => 'manual',
        ];
    }
}

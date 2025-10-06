<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SessionOccurrenceFactory extends Factory
{
    protected $model = \App\Models\SessionOccurrence::class;

    public function definition()
    {
        $start = $this->faker->dateTimeBetween('+1 days', '+1 month');
        $end = (clone $start)->modify('+1 hour');

        return [
            'start_at' => $start,
            'end_at' => $end,
            'capacity' => $this->faker->numberBetween(5, 30),
            'status' => 'active',
            'drive_link' => $this->faker->optional()->url,
            'stats_cached_json' => json_encode(['bookings' => []]),
        ];
    }
}

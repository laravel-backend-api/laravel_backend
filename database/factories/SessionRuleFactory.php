<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SessionRuleFactory extends Factory
{
    protected $model = \App\Models\SessionRule::class;

    public function definition()
    {
        $startHour = $this->faker->numberBetween(6, 18);
        $startMin = $this->faker->randomElement([0, 30]);
        $endHour = $startHour + 1;

        return [
            'weekday' => $this->faker->numberBetween(0, 6),
            'start_time' => sprintf('%02d:%02d', $startHour, $startMin),
            'end_time' => sprintf('%02d:%02d', $endHour, $startMin),
        ];
    }
}

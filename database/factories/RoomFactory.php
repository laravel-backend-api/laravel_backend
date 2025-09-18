<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class RoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'creator_id' => User::factory()->state(['role' => 'creator']),
            'zoom_link' => 'https://zoom.us/j/' . $this->faker->unique()->numerify('##########'),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}

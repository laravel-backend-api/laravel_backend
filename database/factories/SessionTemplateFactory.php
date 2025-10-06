<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SessionTemplate;

class SessionTemplateFactory extends Factory
{
    protected $model = SessionTemplate::class;

    public function definition()
    {
        return [
            'room_id' => null, // set in seeder
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'capacity' => $this->faker->numberBetween(5, 30),
            'status' => 'active',
        ];
    }
}

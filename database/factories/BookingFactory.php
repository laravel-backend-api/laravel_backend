<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = \App\Models\Booking::class;

    public function definition()
    {
        return [
            'status' => $this->faker->randomElement(['booked', 'waitlisted']),
            'booked_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}

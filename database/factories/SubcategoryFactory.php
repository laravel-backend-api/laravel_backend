<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

class SubcategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->word();

        return [
            'category_id' => Category::factory(), // auto link
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}

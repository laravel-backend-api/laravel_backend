<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory(5)
            ->has(Subcategory::factory()->count(3)) // 3 subcategories each
            ->create();
    }
}

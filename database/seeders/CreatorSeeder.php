<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;

class CreatorSeeder extends Seeder
{
    public function run(): void
    {
        // create 10 creators
        User::factory(10)->state(['role' => 'creator'])->create()
            ->each(function ($creator) {
                // each creator has 1-3 rooms
                Room::factory(rand(1, 3))->create(['creator_id' => $creator->id]);
            });
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\SessionTemplate;
use App\Models\SessionRule;
use App\Models\SessionOccurrence;
use App\Models\Booking;
use App\Models\User;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', 'user')->get();

        // Loop through all rooms
        Room::all()->each(function ($room) use ($users) {

            // 2-3 session templates per room
            $room->sessionTemplates()->saveMany(
                SessionTemplate::factory(rand(2, 3))->make()
            )->each(function ($template) use ($users) {

                // 2-4 session rules per template
                $template->sessionRules()->saveMany(
                    SessionRule::factory(rand(2, 4))->make()
                );

                // 3-5 session occurrences per template
                $template->sessionOccurrences()->saveMany(
                    SessionOccurrence::factory(rand(3, 5))->make([
                        'capacity' => $template->capacity
                    ])
                )->each(function ($occurrence) use ($users) {

                    // Randomly assign 0-5 bookings per occurrence
                    $users->random(rand(0, min(5, $users->count())))->each(function ($user) use ($occurrence) {
                        $occurrence->bookings()->save(
                            Booking::factory()->make(['user_id' => $user->id])
                        );
                    });
                });
            });
        });
    }
}

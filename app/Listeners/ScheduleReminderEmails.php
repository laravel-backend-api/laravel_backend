<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Mail\SessionReminder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ScheduleReminderEmails implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking->load('user', 'occurrence');

        $userTz = $booking->user->timezone ?: config('app.timezone');
        $startAtUserTz = $booking->occurrence->start_at->copy()->setTimezone($userTz);
        $sendAt = $startAtUserTz->copy()->subHour();

        if (now($userTz)->lt($sendAt)) {
            Mail::to($booking->user->email)->later($sendAt, new SessionReminder($booking));
        }
    }
}



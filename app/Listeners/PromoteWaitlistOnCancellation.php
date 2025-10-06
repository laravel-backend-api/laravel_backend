<?php

namespace App\Listeners;

use App\Events\BookingCancelled;
use App\Mail\WaitlistPromoted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PromoteWaitlistOnCancellation implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(BookingCancelled $event): void
    {
        $occurrence = $event->booking->occurrence()->lockForUpdate()->first();

        DB::transaction(function () use ($occurrence) {
            $next = $occurrence->bookings()
                ->where('status', 'waitlisted')
                ->orderBy('booked_at')
                ->lockForUpdate()
                ->first();

            if ($next) {
                $next->update(['status' => 'booked']);
                $next->refresh();
                Mail::to($next->user->email)->queue(new WaitlistPromoted($next));
            }
        });
    }
}



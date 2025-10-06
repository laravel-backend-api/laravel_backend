<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Mail\BookingConfirmed;
use App\Mail\CreatorBookedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendBookingEmails implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking->load('user', 'occurrence.template.room.user');

        Mail::to($booking->user->email)->queue(new BookingConfirmed($booking));

        $creator = $booking->occurrence->template->room->user;
        if ($creator && $creator->email) {
            Mail::to($creator->email)->queue(new CreatorBookedNotification($booking));
        }
    }
}



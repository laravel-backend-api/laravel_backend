<?php

namespace App\Services\Mail;

use App\Mail\BookingConfirmed;
use App\Mail\CreatorBookedNotification;
use App\Mail\PasswordResetRequested;
use App\Mail\SessionReminder;
use App\Mail\WaitlistPromoted;
use App\Mail\WelcomeRegistered;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AppMailer implements MailerInterface
{
    public function sendWelcome(User $user): void
    {
        Mail::to($user->email)->queue(new WelcomeRegistered($user));
    }

    public function sendPasswordResetOtp(string $email, string $otp): void
    {
        Mail::to($email)->queue(new PasswordResetRequested($otp));
    }

    public function sendBookingConfirmed(int $userId, int $bookingId): void
    {
        $booking = Booking::with('user')->findOrFail($bookingId);
        Mail::to($booking->user->email)->queue(new BookingConfirmed($booking));
    }

    public function sendSessionReminder(int $userId, int $bookingId, \DateTimeInterface $sendAt): void
    {
        $booking = Booking::with('user')->findOrFail($bookingId);
        Mail::to($booking->user->email)->later($sendAt, new SessionReminder($booking));
    }

    public function sendWaitlistPromoted(int $userId, int $bookingId): void
    {
        $booking = Booking::with('user')->findOrFail($bookingId);
        Mail::to($booking->user->email)->queue(new WaitlistPromoted($booking));
    }

    public function notifyCreatorBooked(int $creatorUserId, int $bookingId): void
    {
        $booking = Booking::with('occurrence.template.room.user')->findOrFail($bookingId);
        $creator = $booking->occurrence->template->room->user;
        if ($creator && $creator->email) {
            Mail::to($creator->email)->queue(new CreatorBookedNotification($booking));
        }
    }
}



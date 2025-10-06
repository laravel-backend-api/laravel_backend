<?php

namespace App\Services\Mail;

use App\Models\User;

interface MailerInterface
{
    public function sendWelcome(User $user): void;
    public function sendPasswordResetOtp(string $email, string $otp): void;
    public function sendBookingConfirmed(int $userId, int $bookingId): void;
    public function sendSessionReminder(int $userId, int $bookingId, \DateTimeInterface $sendAt): void;
    public function sendWaitlistPromoted(int $userId, int $bookingId): void;
    public function notifyCreatorBooked(int $creatorUserId, int $bookingId): void;
}



<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetRequested extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $otp)
    {
    }

    public function build()
    {
        return $this->subject('Your password reset code')
            ->view('emails.auth.password_reset_requested', [
                'otp' => $this->otp,
            ]);
    }
}



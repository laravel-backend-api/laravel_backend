<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreatorEmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $otp)
    {
    }

    public function build()
    {
        return $this->subject('Verify your creator email')
            ->view('emails.auth.creator_verify', [
                'otp' => $this->otp,
            ]);
    }
}



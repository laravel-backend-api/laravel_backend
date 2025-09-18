<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailVerifyOtp extends Mailable
{
    use Queueable, SerializesModels;

    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function build(): self
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject('Verify OTP')
                    ->html("<h1>Your verification token is: {$this->token}</h1>");
    }
}

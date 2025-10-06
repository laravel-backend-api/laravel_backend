<?php

namespace App\Providers;

use App\Services\Mail\AppMailer;
use App\Services\Mail\MailerInterface;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MailerInterface::class, function () {
            return new AppMailer();
        });
    }
}



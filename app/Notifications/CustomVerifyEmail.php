<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends BaseVerifyEmail
{
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('Welcome to PB Student Portal')
            ->greeting('Hello!')
            ->line('Thank you for registering! Please verify your email to access your dashboard.')
            ->action('Verify My Email', $url)
            ->line('PB Student Portal');
    }
}

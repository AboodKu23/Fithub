<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationCodeNotification extends Notification
{
    use Queueable;

    protected string $code;
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Email Verification Code')
            ->line("Your verification code is: **{$this->code}**")
            ->line('This code will expire in 10 minutes.')
            ->line('If you did not request this, no action is required.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

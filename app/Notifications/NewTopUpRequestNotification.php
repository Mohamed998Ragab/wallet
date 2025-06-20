<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewTopUpRequestNotification extends Notification
{
    use Queueable;

    protected $topUpRequest;

    public function __construct($topUpRequest)
    {
        $this->topUpRequest = $topUpRequest;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('A new top-up request has been created.')
                    ->action('View Request', url('/admin/top-ups'))
                    ->line('Amount: ' . number_format($this->topUpRequest->amount, 2));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'New top-up request by ' . $this->topUpRequest->user->name,
            'link' => '/admin/top-ups',
        ];
    }
}
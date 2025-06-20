<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewWithdrawalRequestNotification extends Notification
{
    use Queueable;

    protected $withdrawalRequest;

    public function __construct($withdrawalRequest)
    {
        $this->withdrawalRequest = $withdrawalRequest;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('A new withdrawal request has been created.')
                    ->action('View Request', url('/admin/withdrawals'))
                    ->line('Amount: ' . number_format($this->withdrawalRequest->amount, 2));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'New withdrawal request by ' . $this->withdrawalRequest->admin->name,
            'link' => '/admin/withdrawals',
        ];
    }
}
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TransactionNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $type;
    protected $icon;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $type, $icon)
    {
        $this->message = $message;
        $this->type = $type;
        $this->icon = $icon;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['database'];
    } 

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'message' => $this->message,
            'type' => $this->type,
            'icon' => $this->icon
        ];
    }
}

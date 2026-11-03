<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminSystemNotification extends Notification
{
    use Queueable;

    public string $title;
    public string $message;
    public string $type;
    public string $icon;
    public ?string $link;

    public function __construct(
        string $title,
        string $message,
        string $type = 'info',
        string $icon = 'bi-bell-fill',
        ?string $link = null
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->icon = $icon;
        $this->link = $link;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'icon' => $this->icon,
            'link' => $this->link,
        ];
    }
}

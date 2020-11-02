<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use Illuminate\Support\Facades\Auth;


class Push extends Notification
{

    use Queueable;
    
    
    
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Beer Alert')
            ->icon('/BeerAlert/public/beer-ico-72x72.png')
            ->body('Tu cerveza está lista!')
            ->action('View App', 'notification_action');
    }
    
}
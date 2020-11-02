<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use Illuminate\Support\Facades\Auth;


class Push2 extends Notification
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
            ->body('Atención, tu cerveza se va a congelar si no la sacas del freezer!')
            ->action('View App', 'notification_action');
    }
    
}
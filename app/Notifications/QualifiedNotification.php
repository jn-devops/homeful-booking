<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use LBHurtado\EngageSpark\EngageSparkChannel;
use LBHurtado\EngageSpark\EngageSparkMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use App\Mail\Qualified;

class QualifiedNotification extends Notification
{
    use Queueable;
    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', EngageSparkChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): Qualified
    {
        return new Qualified($notifiable);
    }

    public function toEngageSpark($notifiable)
    {
        $content = view('sms.qualified', [
            'user' => $notifiable,
            'name' => "Chona Andrade",
            'code' => "JN-123456",
            'due_date' => "August 1, 2024",
            ])->render();

        return (new EngageSparkMessage())
            ->content($content);
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
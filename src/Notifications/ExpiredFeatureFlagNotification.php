<?php

namespace Mohamedahmed01\FeatureFlag\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpiredFeatureFlagNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $featureFlag;

    public function __construct($featureFlag)
    {
        $this->featureFlag = $featureFlag;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $name = $this->featureFlag->name;
        $date = $this->featureFlag->finish_date;

        return (new MailMessage)
            ->error()
            ->subject("Feature Flag '$name' has expired")
            ->line("The feature flag '$name' has expired on $date.");
    }
}
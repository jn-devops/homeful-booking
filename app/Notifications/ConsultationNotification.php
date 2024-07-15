<?php

namespace App\Notifications;

class ConsultationNotification extends HomefulNotification
{
    protected function getContent(): string
    {
        return 'Nag-consult ka na. Magbabayad ka uli.';
    }
}

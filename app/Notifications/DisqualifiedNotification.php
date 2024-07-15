<?php

namespace App\Notifications;

class DisqualifiedNotification extends HomefulNotification
{
    protected function getContent(): string
    {
        return 'Disqualified ka na. Magbabayad ka uli.';
    }
}

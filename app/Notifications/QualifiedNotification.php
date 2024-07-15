<?php

namespace App\Notifications;

class QualifiedNotification extends HomefulNotification
{
    protected function getContent(): string
    {
        return 'Qualified ka na. Magbabayad ka uli.';
    }
}

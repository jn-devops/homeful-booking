<?php

namespace App\Notifications;

class ApprovalNotification extends HomefulNotification
{
    protected function getContent(): string
    {
        return 'Approved ka na. Magbabayad ka uli.';
    }
}

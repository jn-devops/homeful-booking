<?php

namespace App\Notifications;

class PaymentNotification extends HomefulNotification
{
    protected function getContent(): string
    {
        return 'Bayad ka na. Magbabayad ka uli.';
    }
}

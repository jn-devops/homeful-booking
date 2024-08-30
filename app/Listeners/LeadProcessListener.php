<?php

namespace App\Listeners;

use Homeful\KwYCCheck\Events\LeadProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LeadProcessListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LeadProcessed $event): void
    {

    }
}

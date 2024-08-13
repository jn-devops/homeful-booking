<?php

use Homeful\Mortgage\Providers\EventServiceProvider as HomefulEventServiceProvider;


return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    HomefulEventServiceProvider::class,

];

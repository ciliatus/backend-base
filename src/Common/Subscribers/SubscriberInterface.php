<?php

namespace App\MyProject\Common\Subscribers;

use Illuminate\Events\Dispatcher;

interface SubscriberInterface
{

    public function subscribe(Dispatcher $events): void;

}

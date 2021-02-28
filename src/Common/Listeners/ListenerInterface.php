<?php

namespace App\MyProject\Common\Listeners;

use App\MyProject\Common\Events\Event;

interface ListenerInterface
{

    public function handle(Event $event): void;

}

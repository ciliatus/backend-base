<?php

namespace App\MyProject\Common\Enum;

/**
 * @method static AlertEventsEnum ALERT_STARTED
 * @method static AlertEventsEnum ALERT_ENDED
 * @method static AlertEventsEnum ALERT_ESCALATED
 */
class AlertEventsEnum extends Enum
{

    private const ALERT_STARTED = 'ciliatus.common::alert.events.started';
    private const ALERT_ENDED = 'ciliatus.common::alert.events.ended';
    private const ALERT_ESCALATED = 'ciliatus.common::alert.events.escalated';

}

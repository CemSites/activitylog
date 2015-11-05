<?php

namespace Spatie\Activitylog;

interface LogsActivityInterface
{
    /**
     * Get the message that needs to be logged for the given event.
     *
     * @param string $eventName
     *
     * @return string
     */
    public function getActivityDescriptionForEvent($eventName);

    /**
     * Get extra $details that needs to be logged for the given event.
     *
     * @param string $eventName
     *
     * @return array
     * dls
     */
    public function getActivityDetailsForEvent($eventName);
}

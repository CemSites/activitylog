<?php

namespace Spatie\Activitylog\Handlers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class EloquentHandler implements ActivitylogHandlerInterface
{
    /**
     * Log activity in an Eloquent model.
     *
     * @param string $text
     * @param $userId
     * @param array  $attributes
     *
     * @return bool
     */
    public function log($text, $userId = '', $attributes = [])
    {
        $path = Request::decodedPath();
        $method = Request::getMethod();
        $ajax = Request::ajax() ? 1 : 0;
        Activity::create(
            [
                'activity_type' => $attributes['activity_type'],
                'text' => $text,
                'record_type' => isset($attributes['record_type']) ? $attributes['record_type']:'',
                'record_id' => isset($attributes['record_id']) ? $attributes['record_id']:'',
                'user_id' => ($userId == '' ? null : $userId),
                'ip_address' => $attributes['ipAddress'],
                'route' => $path,
                'method' => $method,
                'view_link' => isset($attributes['view_link']) ? $attributes['view_link']:'',
                'ajax' => $ajax,
            ]
        );

        return true;
    }

    /**
     * Clean old log records.
     *
     * @param int $maxAgeInMonths
     *
     * @return bool
     */
    public function cleanLog($maxAgeInMonths)
    {
        $minimumDate = Carbon::now()->subMonths($maxAgeInMonths);
        Activity::where('created_at', '<=', $minimumDate)->delete();

        return true;
    }
}

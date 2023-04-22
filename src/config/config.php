<?php
return [
    'feature_flag' => [
        'driver' => env('FEATURE_FLAG_DRIVER', 'eloquent'),
        'notification_email' => env('FEATURE_FLAG_NOTIFICATION_EMAIL', 'admin@admin.com'),
        'finish_date_action' => env('FEATURE_FLAG_FINISH_DATE_ACTION', 'exception'),
    ]
];
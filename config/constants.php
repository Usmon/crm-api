<?php

/*
|--------------------------------------------------------------------------
| Notification services URL
|--------------------------------------------------------------------------
*/
$url = env('NOTIFICATION_SERVICE_URL');

return [
    'notification_url' => [
        'sms' => $url . '/sms',

        'email' => $url . '/email',
    ],
];

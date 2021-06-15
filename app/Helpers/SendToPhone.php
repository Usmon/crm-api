<?php

namespace App\Helpers;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\Log;

use GuzzleHttp\Exception\GuzzleException;

final class SendToPhone
{
    public static function sendToPhone(string $phone, string $message): void
    {
        try {
            (new Client())->post(
                config('constants.notification_url.sms'),
                [
                    'body' => json_encode([
                        'phone' => $phone,

                        'message' => $message,
                    ]),
                ],
            );
        } catch (GuzzleException $e){
            Log::error('Some error, please try again later.', ['Send to phone message']);
        }
    }
}

<?php

namespace App\Helpers;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\Log;

use GuzzleHttp\Exception\GuzzleException;

final class SendToEmail
{
    public static function sentToEmail(string $email, string $subject, string $message): void
    {
        try {
            (new Client())->post(
            config('constants.notification_url.email'),
                [
                    'body' => json_encode([
                        'email' => $email,

                        'subject' => $subject,

                        'message' => $message,
                    ]),
                ],
            );
        } catch (GuzzleException $e){
            Log::error('Some error, please try again later.', ['Send to email message']);
        }
    }
}

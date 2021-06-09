<?php


namespace App\Logic\Notifications\Email\Services;


use App\Helpers\SendToEmail;

use App\Logic\Notifications\Email\Requests\Send as SendRequest;

class EmailSender
{
    /**
     * @param SendRequest $request
     *
     * @return array
     */
    public function getSenderCredentials(SendRequest $request): array
    {
        return [
            'emails' => $request->json('emails'),

            'subject' => $request->json('subject'),

            'body' => $request->json('body')
        ];
    }

    /**
     * @param array $credentials
     */
    public function send(array $credentials): void
    {
        foreach ($credentials['emails'] as $index => $email)
        {
            SendToEmail::sentToEmail($email, $credentials['subject'], $credentials['body']);
        }
    }
}

<?php


namespace App\Http\Controllers\Notifications\Email;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Notifications\Email\Requests\Send as SendRequest;

use App\Logic\Notifications\Email\Services\EmailSender as EmailSenderService;

/**
 * Class Controller
 * @package App\Http\Controllers\Dashboard\Email
 */
final class Controller extends Controllers
{
    /**
     * @var EmailSenderService
     */
    private $service;

    /**
     * Controller constructor.
     *
     * @param EmailSenderService $service
     */
    public function __construct(EmailSenderService $service)
    {
        $this->service = $service;
    }

    /**
     * @param SendRequest $request
     *
     * @return JsonResponse
     */
    public function send(SendRequest $request): JsonResponse
    {
        $this->service->send($this->service->getSenderCredentials($request));

        return Json::sendJsonWith200([
            'message' => 'Your message has been sent successfully!',
        ]);
    }
}

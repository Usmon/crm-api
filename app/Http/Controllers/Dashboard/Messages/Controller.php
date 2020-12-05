<?php

namespace App\Http\Controllers\Dashboard\Messages;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Messages as MessagesRequest;

use App\Logic\Dashboard\CRUD\Services\Messages as MessagesService;

use App\Logic\Dashboard\CRUD\Repositories\Messages as MessagesRepository;

use App\Models\Message;

use Illuminate\Http\JsonResponse;

final class Controller extends Controllers
{
    /**
     * @var MessagesService
     */
    protected $service;

    /**
     * @var MessagesRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param MessagesService $service
     *
     * @param MessagesRepository $repository
     *
     */
    public function __construct(MessagesService $service, MessagesRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param MessagesRequest $request
     *
     * @return JsonResponse
     */
    public function index(MessagesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'messages' => $this->service->getMessages($this->repository->getMessages($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param MessagesRequest $request
     *
     * @return JsonResponse
     */
    public function store(MessagesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The message was successfully created.',
            'messageModel' => $this->repository->storeMessage($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Message $message
     *
     * @return JsonResponse
     */
    public function show(Message $message): JsonResponse
    {
        return Json::sendJsonWith200([
            'messageModel' => $this->service->showMessage($message),
        ]);
    }

    /**
     * @param MessagesRequest $request
     *
     * @param Message $message
     *
     * @return JsonResponse
     */
    public function update(MessagesRequest $request, Message $message): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The message was successfully updated.',

            'messageModel' => $this->repository->updateRecipient($message, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteMessage($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete message, parameters does not match.',
            ]);
        }

        $this->repository->deleteMessage($id);

        return Json::sendJsonWith200([
            'message' => 'The message was successfully deleted.',
        ]);
    }
}

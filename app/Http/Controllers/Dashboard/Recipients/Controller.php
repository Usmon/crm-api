<?php

namespace App\Http\Controllers\Dashboard\Recipients;

use App\Helpers\Json;

use App\Models\Recipient;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Recipients as RecipientsRequest;

use App\Logic\Dashboard\CRUD\Services\Recipients as RecipientsService;

use App\Logic\Dashboard\CRUD\Repositories\Recipients as RecipientsRepository;

final class Controller extends Controllers
{
    /**
     * @var RecipientsService
     */
    protected $service;

    /**
     * @var RecipientsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param RecipientsService $service
     *
     * @param RecipientsRepository $repository
     */
    public function __construct(RecipientsService $service, RecipientsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param RecipientsRequest $request
     *
     * @return JsonResponse
     */
    public function index(RecipientsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getAllSorts($request),

            'recipients' => $this->service->getRecipients($this->repository->getRecipients(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request)
            )),
        ]);
    }

    /**
     * @param RecipientsRequest $request
     *
     * @return JsonResponse
     */
    public function recipientPhoneCheck(RecipientsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'recipient' => $this->service->showRecipientPhone($this->repository->checkPhone($this->service->getOnlyPhone($request))),
        ]);
    }

    /**
     * @param RecipientsRequest $request
     *
     * @return JsonResponse
     */
    public function store(RecipientsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The recipient was successfully created.',

            'recipient' => $this->repository->storeRecipient($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Recipient $recipient
     *
     * @return JsonResponse
     */
    public function show(Recipient $recipient): JsonResponse
    {
        return Json::sendJsonWith200([
            'recipient' => $this->service->showRecipient($recipient),
        ]);
    }

    /**
     * @param RecipientsRequest $request
     *
     * @param Recipient $recipient
     *
     * @return JsonResponse
     */
    public function update(RecipientsRequest $request, Recipient $recipient): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The recipient was successfully updated.',

            'recipient' => $this->repository->updateRecipient($recipient, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteRecipient($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete recipient, parameters does not match.',
            ]);
        }

        $this->repository->deleteRecipient($id);

        return Json::sendJsonWith200([
            'message' => 'The recipient was successfully deleted.',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Dashboard\Senders;

use App\Helpers\Json;

use App\Models\Sender;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Senders as SendersRequest;

use App\Logic\Dashboard\CRUD\Services\Senders as SendersService;

use App\Logic\Dashboard\CRUD\Repositories\Senders as SendersRepository;

final class Controller extends Controllers
{
    /**
     * @var SendersService
     */
    protected $service;

    /**
     * @var SendersRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param SendersService $service
     *
     * @param SendersRepository $repository
     */
    public function __construct(SendersService $service, SendersRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param SendersRequest $request
     *
     * @return JsonResponse
     */
    public function index(SendersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getAllSorts($request),

            'senders' => $this->service->getSenders($this->repository->getSenders(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request)
            )),
        ]);
    }

    /**
     * @param SendersRequest $request
     *
     * @return JsonResponse
     */
    public function senderPhoneCheck(SendersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'sender' => $this->service->showSenderPhone($this->repository->checkPhone($this->service->getOnlyPhone($request))),
        ]);
    }

    /**
     * @param SendersRequest $request
     *
     * @return JsonResponse
     */
    public function phoneSearch(SendersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'phones' => $this->service->getPhones($this->repository->searchByPhone($this->service->getOnlyPhone($request)))
        ]);
    }

    /**
     * @param SendersRequest $request
     *
     * @return JsonResponse
     */
    public function store(SendersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The sender was successfully created.',

            'sender' => $this->repository->storeSender($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Sender $sender
     *
     * @return JsonResponse
     */
    public function show(Sender $sender): JsonResponse
    {
        return Json::sendJsonWith200([
            'sender' => $this->service->showSender($sender),
        ]);
    }

    /**
     * @param SendersRequest $request
     *
     * @param Sender $sender
     *
     * @return JsonResponse
     */
    public function update(SendersRequest $request, Sender $sender): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The sender was successfully updated.',

            'sender' => $this->repository->updateSender($sender, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteSender($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete sender, parameters does not match.',
            ]);
        }

        $this->repository->deleteSender($id);

        return Json::sendJsonWith200([
            'message' => 'The sender was successfully deleted.',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Dashboard\Phones;

use App\Helpers\Json;

use App\Models\Phone;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Phones as PhonesRequest;

use App\Logic\Dashboard\CRUD\Services\Phones as PhonesService;

use App\Logic\Dashboard\CRUD\Repositories\Phones as PhonesRepository;

final class Controller extends Controllers
{
    /**
     * @var PhonesService
     */
    protected $service;

    /**
     * @var PhonesRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param PhonesService $service
     *
     * @param PhonesRepository $repository
     */
    public function __construct(PhonesService $service, PhonesRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param PhonesRequest $request
     *
     * @return JsonResponse
     */
    public function index(PhonesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'phones' => $this->service->getPhones($this->repository->getPhones(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request))),
        ]);
    }

    /**
     * @param PhonesRequest $request
     *
     * @return JsonResponse
     */
    public function store(PhonesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The phone was successfully created.',

            'phone' => $this->repository->storePhone($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Phone $phone
     *
     * @return JsonResponse
     */
    public function show(Phone $phone): JsonResponse
    {
        return Json::sendJsonWith200([
            'phone' => $this->service->showPhone($phone),
        ]);
    }

    /**
     * @param PhonesRequest $request
     *
     * @param Phone $phone
     *
     * @return JsonResponse
     */
    public function update(PhonesRequest $request, Phone $phone): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The phone was successfully updated.',

            'phone' => $this->repository->updatePhone($phone, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deletePhone($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete phone, parameters does not match.',
            ]);
        }

        $this->repository->deletePhone($id);

        return Json::sendJsonWith200([
            'message' => 'The phone was successfully deleted.',
        ]);
    }
}

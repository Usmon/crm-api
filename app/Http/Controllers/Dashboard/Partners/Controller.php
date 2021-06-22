<?php

namespace App\Http\Controllers\Dashboard\Partners;

use App\Helpers\Json;

use App\Models\Partner;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Partners as PartnersRequest;

use App\Logic\Dashboard\CRUD\Services\Partners as PartnersService;

use App\Logic\Dashboard\CRUD\Repositories\Partners as PartnersRepository;

final class Controller extends Controllers
{
    /**
     * @var PartnersService
     */
    protected $service;

    /**
     * @var PartnersRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param PartnersService $service
     *
     * @param PartnersRepository $repository
     */
    public function __construct(PartnersService $service, PartnersRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param PartnersRequest $request
     *
     * @return JsonResponse
     */
    public function index(PartnersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'partners' => $this->service->getPartners($this->repository->getPartners(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request))),
        ]);
    }

    /**
     * @param PartnersRequest $request
     *
     * @return JsonResponse
     */
    public function store(PartnersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The partner was successfully created.',

            'partner' => $this->service->showPartner($this->repository->storePartner($this->service->storeCredentials($request))),
        ]);
    }

    /**
     * @param Partner $partner
     *
     * @return JsonResponse
     */
    public function show(Partner $partner): JsonResponse
    {
        return Json::sendJsonWith200([
            'partner' => $this->service->showPartner($partner),
        ]);
    }

    /**
     * @param PartnersRequest $request
     *
     * @param Partner $partner
     *
     * @return JsonResponse
     */
    public function update(PartnersRequest $request, Partner $partner): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The partner was successfully updated.',

            'partner' => $this->service->showPartner($this->repository->updatePartner($partner, $this->service->updateCredentials($request))),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deletePartner($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete partner, parameters does not match.',
            ]);
        }

        $this->repository->deletePartner($id);

        return Json::sendJsonWith200([
            'message' => 'The partner was successfully deleted.',
        ]);
    }
}

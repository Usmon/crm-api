<?php

namespace App\Http\Controllers\Dashboard\Regions;

use App\Helpers\Json;

use App\Models\Region;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Regions as RegionsRequest;

use App\Logic\Dashboard\CRUD\Services\Regions as RegionsService;

use App\Logic\Dashboard\CRUD\Repositories\Regions as RegionsRepository;

final class Controller extends Controllers
{
    /**
     * @var RegionsService
     */
    protected $service;

    /**
     * @var RegionsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param RegionsService $service
     *
     * @param RegionsRepository $repository
     */
    public function __construct(RegionsService $service, RegionsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param RegionsRequest $request
     *
     * @return JsonResponse
     */
    public function index(RegionsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'regions' => $this->service->getRegions($this->repository->getRegions(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request))),
        ]);
    }

    /**
     * @param RegionsRequest $request
     *
     * @return JsonResponse
     */
    public function store(RegionsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The region was successfully created.',

            'region' => $this->repository->storeRegion($this->service->storeCredentials($request)),
        ]);
    }


    /**
     * @param Region $region
     *
     * @return JsonResponse
     */
    public function show(Region $region): JsonResponse
    {
        return Json::sendJsonWith200([
            'region' => $this->service->showRegion($region),
        ]);
    }

    /**
     * @param RegionsRequest $request
     *
     * @param Region $region
     *
     * @return JsonResponse
     */
    public function update(RegionsRequest $request, Region $region): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The region was successfully updated.',

            'region' => $this->repository->updateRegion($region, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteRegion($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete region, parameters does not match.',
            ]);
        }

        $this->repository->deleteRegion($id);

        return Json::sendJsonWith200([
            'message' => 'The region was successfully deleted.',
        ]);
    }




}

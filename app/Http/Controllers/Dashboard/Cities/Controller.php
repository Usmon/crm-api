<?php

namespace App\Http\Controllers\Dashboard\Cities;

use App\Helpers\Json;

use App\Models\City;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Cities as CitiesRequest;

use App\Logic\Dashboard\CRUD\Services\Cities as CitiesService;

use App\Logic\Dashboard\CRUD\Repositories\Cities as CitiesRepository;

final class Controller extends Controllers
{
    /**
     * @var CitiesService
     */
    protected $service;

    /**
     * @var CitiesRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param CitiesService $service
     *
     * @param CitiesRepository $repository
     */
    public function __construct(CitiesService $service, CitiesRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param CitiesRequest $request
     *
     * @return JsonResponse
     */
    public function index(CitiesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'cities' => $this->service->getCities($this->repository->getCities(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request))),
        ]);
    }

    /**
     * @param CitiesRequest $request
     *
     * @return JsonResponse
     */
    public function store(CitiesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The city was successfully created.',

            'city' => $this->repository->storeCity($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param City $city
     *
     * @return JsonResponse
     */
    public function show(City $city): JsonResponse
    {
        return Json::sendJsonWith200([
            'city' => $this->service->showCity($city),
        ]);
    }

    /**
     * @param CitiesRequest $request
     *
     * @param City $city
     *
     * @return JsonResponse
     */
    public function update(CitiesRequest $request, City $city): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The city was successfully updated.',

            'city' => $this->repository->updateCity($city, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteCity($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete city, parameters does not match.',
            ]);
        }

        $this->repository->deleteCity($id);

        return Json::sendJsonWith200([
            'message' => 'The city was successfully deleted.',
        ]);
    }
}

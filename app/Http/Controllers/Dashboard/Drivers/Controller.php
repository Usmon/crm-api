<?php

namespace App\Http\Controllers\Dashboard\Drivers;

use App\Helpers\Json;

use App\Models\Driver;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Drivers as DriversRequest;

use App\Logic\Dashboard\CRUD\Services\Drivers as DriversService;

use App\Logic\Dashboard\CRUD\Repositories\Drivers as DriversRepository;
use Illuminate\Support\Facades\Gate;

final class Controller extends Controllers
{
    /**
     * @var DriversService
     */
    protected $service;

    /**
     * @var DriversRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param DriversService $service
     *
     * @param DriversRepository $repository
     */
    public function __construct(DriversService $service, DriversRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param DriversRequest $request
     *
     * @return JsonResponse
     */
    public function index(DriversRequest $request): JsonResponse
    {
        if(! Gate::check('Drivers')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'drivers' => $this->service->getDrivers($this->repository->getDrivers(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request))),
        ]);
    }

    /**
     * @param DriversRequest $request
     *
     * @return JsonResponse
     */
    public function store(DriversRequest $request): JsonResponse
    {
        if(! Gate::check('Drivers')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The driver was successfully created.',

            'driver' => $this->service->showDriver($this->repository->storeDriver($this->service->storeCredentials($request))),
        ]);
    }

    /**
     * @param Driver $driver
     *
     * @return JsonResponse
     */
    public function show(Driver $driver): JsonResponse
    {
        if(! Gate::check('Drivers')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        return Json::sendJsonWith200([
            'driver' => $this->service->showDriver($driver),
        ]);
    }

    /**
     * @param DriversRequest $request
     *
     * @param Driver $driver
     *
     * @return JsonResponse
     */
    public function update(DriversRequest $request, Driver $driver): JsonResponse
    {
        if(! Gate::check('Drivers')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The driver was successfully updated.',

            'address' => $this->service->showDriver($this->repository->updateDriver($driver, $this->service->updateCredentials($request))),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if(! Gate::check('Drivers')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        $id = $this->service->deleteDriver($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete driver, parameters does not match.',
            ]);
        }

        $this->repository->deleteDriver($id);

        return Json::sendJsonWith200([
            'message' => 'The driver was successfully deleted.',
        ]);
    }

    /**
     * @param DriversRequest $request
     *
     * @return JsonResponse
     */
    public function driverPhoneCheck(DriversRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
           'driver' => $this->service->showDriverPhone(
               $this->repository->checkPhone($this->service->getOnlyPhone($request)),
               $this->service->getOnlyPhone($request)
           )
        ]);
    }

    /**
     * @param DriversRequest $request
     *
     * @return JsonResponse
     */
    public function phoneSearch(DriversRequest $request): JsonResponse
    {
        {
            return Json::sendJsonWith200([
                'phones' => $this->service->getPhones(
                    $this->repository->searchByPhone
                    ($this->service->getOnlyPhone($request)), $this->service->getOnlyPhone($request))
            ]);
        }
    }
}

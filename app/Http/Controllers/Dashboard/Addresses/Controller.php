<?php

namespace App\Http\Controllers\Dashboard\Addresses;

use App\Helpers\Json;

use App\Models\Address;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Addresses as AddressesRequest;

use App\Logic\Dashboard\CRUD\Services\Addresses as AddressesService;

use App\Logic\Dashboard\CRUD\Repositories\Addresses as AddressesRepository;

final class Controller extends Controllers
{
    /**
     * @var AddressesService
     */
    protected $service;

    /**
     * @var AddressesRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param AddressesService $service
     *
     * @param AddressesRepository $repository
     */
    public function __construct(AddressesService $service, AddressesRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param AddressesRequest $request
     *
     * @return JsonResponse
     */
    public function index(AddressesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'addresses' => $this->service->getAddresses($this->repository->getAddresses(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request))),
        ]);
    }

    /**
     * @param AddressesRequest $request
     *
     * @return JsonResponse
     */
    public function store(AddressesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The address was successfully created.',

            'address' => $this->repository->storeAddress($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Address $address
     *
     * @return JsonResponse
     */
    public function show(Address $address): JsonResponse
    {
        return Json::sendJsonWith200([
            'address' => $this->service->showAddress($address),
        ]);
    }

    /**
     * @param AddressesRequest $request
     *
     * @param Address $address
     *
     * @return JsonResponse
     */
    public function update(AddressesRequest $request, Address $address): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The address was successfully updated.',

            'address' => $this->repository->updateAddress($address, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteAddress($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete address, parameters does not match.',
            ]);
        }

        $this->repository->deleteAddress($id);

        return Json::sendJsonWith200([
            'message' => 'The address was successfully deleted.',
        ]);
    }
}

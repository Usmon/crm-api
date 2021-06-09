<?php

namespace App\Http\Controllers\Dashboard\Customers;

use App\Helpers\Json;

use App\Models\Customer;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Customers as CustomersRequest;

use App\Logic\Dashboard\CRUD\Services\Customers as CustomersService;

use App\Logic\Dashboard\CRUD\Repositories\Customers as CustomersRepository;

final class Controller extends Controllers
{
    /**
     * @var CustomersService
     */
    protected $service;

    /**
     * @var CustomersRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param CustomersService $service
     *
     * @param CustomersRepository $repository
     */
    public function __construct(CustomersService $service, CustomersRepository $repository)
    {
        $this->checkPermission('Customers');

        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param CustomersRequest $request
     *
     * @return JsonResponse
     */
    public function index(CustomersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'customers' => $this->service->getCustomers($this->repository->getCustomers($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param CustomersRequest $request
     *
     * @return JsonResponse
     */
    public function store(CustomersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The customer was successfully created.',

            'customer' => $this->repository->storeCustomer($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Customer $customer
     *
     * @return JsonResponse
     */
    public function show(Customer $customer): JsonResponse
    {
        return Json::sendJsonWith200([
            'customer' => $this->service->showCustomer($customer),
        ]);
    }

    /**
     * @param CustomersRequest $request
     *
     * @param Customer $customer
     *
     * @return JsonResponse
     */
    public function update(CustomersRequest $request, Customer $customer): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The customer was successfully updated.',

            'customer' => $this->repository->updateCustomer($customer, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteCustomer($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete customer, parameters does not match.',
            ]);
        }

        $this->repository->deleteCustomer($id);

        return Json::sendJsonWith200([
            'message' => 'The customer was successfully deleted.',
        ]);
    }
}

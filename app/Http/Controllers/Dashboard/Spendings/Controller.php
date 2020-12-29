<?php

namespace App\Http\Controllers\Dashboard\Spendings;

use App\Helpers\Json;

use App\Models\Spending;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Spendings as SpendingsRequest;

use App\Logic\Dashboard\CRUD\Services\Spendings as SpendingsService;

use App\Logic\Dashboard\CRUD\Repositories\Spendings as SpendingsRepository;


final class Controller extends Controllers
{
    /**
     * @var SpendingsService
     */
    protected $service;

    /**
     * @var SpendingsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param SpendingsService $service
     *
     * @param SpendingsRepository $repository
     */
    public function __construct(SpendingsService $service, SpendingsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param SpendingsRequest $request
     *
     * @return JsonResponse
     */
    public function index(SpendingsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),
            
            'sort' => $this->service->getAllSorts($request),

            'spendings' => $this->service->getSpendings($this->repository->getSpendings(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request),
            )),
        ]);
    }

    /**
     * @param SpendingsRequest $request
     *
     * @return JsonResponse
     */
    public function store(SpendingsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The spending was successfully created.',

            'spending' => $this->repository->storeSpending($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Spending $spending
     *
     * @return JsonResponse
     */
    public function show(Spending $spending): JsonResponse
    {
        return Json::sendJsonWith200([
            'spending' => $this->service->showSpending($spending),
        ]);
    }

    /**
     * @param SpendingsRequest $request
     *
     * @param Spending $spending
     *
     * @return JsonResponse
     */
    public function update(SpendingsRequest $request, Spending $spending): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The spending was successfully updated.',

            'spending' => $this->repository->updateSpending($spending, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteSpending($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete spending, parameters does not match.',
            ]);
        }

        $this->repository->deleteSpending($id);

        return Json::sendJsonWith200([
            'message' => 'The spending was successfully deleted.',
        ]);
    }
}

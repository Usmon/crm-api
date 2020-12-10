<?php

namespace App\Http\Controllers\Dashboard\SpendingCategories;

use App\Helpers\Json;

use App\Models\SpendingCategory;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\SpendingCategories as SpendingCategoriesRequest;

use App\Logic\Dashboard\CRUD\Services\SpendingCategories as SpendingCategoriesService;

use App\Logic\Dashboard\CRUD\Repositories\SpendingCategories as SpendingCategoriesRepository;

final class Controller extends Controllers
{
    /**
     * @var SpendingCategoriesService
     */
    protected $service;

    /**
     * @var SpendingCategoriesRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param SpendingCategoriesService $service
     *
     * @param SpendingCategoriesRepository $repository
     */
    public function __construct(SpendingCategoriesService $service, SpendingCategoriesRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param SpendingCategoriesRequest $request
     *
     * @return JsonResponse
     */
    public function index(SpendingCategoriesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'spending-categories' => $this->service->getSpendingCategories($this->repository->getSpendingCategories($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param SpendingCategoriesRequest $request
     *
     * @return JsonResponse
     */
    public function store(SpendingCategoriesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The spending-category was successfully created.',

            'spending-category' => $this->repository->storeSpendingCategory($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param SpendingCategory $spendingCategory
     *
     * @return JsonResponse
     */
    public function show(SpendingCategory $spendingCategory): JsonResponse
    {
        return Json::sendJsonWith200([
            'spending-category' => $this->service->showSpendingCategory($spendingCategory),
        ]);
    }

    /**
     * @param SpendingCategoriesRequest $request
     *
     * @param SpendingCategory $spendingCategory
     *
     * @return JsonResponse
     */
    public function update(SpendingCategoriesRequest $request, SpendingCategory $spendingCategory): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The spending-category was successfully updated.',

            'spending-category' => $this->repository->updateSpendingCategory($spendingCategory, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteSpendingCategory($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete spending-category, parameters does not match.',
            ]);
        }

        $this->repository->deleteSpendingCategory($id);

        return Json::sendJsonWith200([
            'message' => 'The spending-category was successfully deleted.',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Dashboard\Products;

use App\Helpers\Json;

use App\Models\Product;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Products as ProductsRequest;

use App\Logic\Dashboard\CRUD\Services\Products as ProductsService;

use App\Logic\Dashboard\CRUD\Repositories\Products as ProductsRepository;

final class Controller extends Controllers
{
    /**
     * @var ProductsService
     */
    protected $service;

    /**
     * @var ProductsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param ProductsService $service
     *
     * @param ProductsRepository $repository
     */
    public function __construct(ProductsService $service, ProductsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param ProductsRequest $request
     *
     * @return JsonResponse
     */
    public function index(ProductsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'products' => $this->service->getProducts($this->repository->getProducts(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request))),
        ]);
    }

    /**
     * @param ProductsRequest $request
     *
     * @return JsonResponse
     */
    public function store(ProductsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The product was successfully created.',

            'tracking' => $this->repository->storeProduct($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Product $product
     *
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return Json::sendJsonWith200([
            'tracking' => $this->service->showProduct($product),
        ]);
    }

    /**
     * @param ProductsRequest $request
     *
     * @param Product $product
     *
     * @return JsonResponse
     */
    public function update(ProductsRequest $request, Product $product): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The product was successfully updated.',

            'product' => $this->repository->updateProduct($product, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteProduct($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete product, parameters does not match.',
            ]);
        }

        $this->repository->deleteProduct($id);

        return Json::sendJsonWith200([
            'message' => 'The product was successfully deleted.',
        ]);
    }
}

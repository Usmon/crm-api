<?php

namespace App\Http\Controllers\Dashboard\Boxes;

use App\Models\Box;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Boxes as BoxesRequest;

use App\Logic\Dashboard\CRUD\Services\Boxes as BoxesService;

use App\Logic\Dashboard\CRUD\Repositories\Boxes as BoxesRepository;

use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

final class Controller extends Controllers
{
    /**
     * @var BoxesService
     */
    protected $service;

    /**
     * @var BoxesRepository
     */
    protected $repository;

    /**
     * @param BoxesService $service
     *
     * @param BoxesRepository $repository
     *
     * @return void
     */
    public function __construct(BoxesService $service, BoxesRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param BoxesRequest $request
     *
     * @return JsonResponse
     */
    public function index(BoxesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getAllSorts($request),

            'boxes' => $this->service->getBoxes($this->repository->getBoxes(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request)
            ))

        ]);

    }

    /**
     * @param BoxesRequest $request
     *
     * @return JsonResponse
     */
    public function store(BoxesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The box was successfully created.',

            'box' => $this->repository->storeBox($this->service->createBox($request)),
        ]);
    }

    /**
     * @param Box $box
     *
     * @return JsonResponse
     */
    public function show(Box $box): JsonResponse
    {
        return Json::sendJsonWith200([
            'box' => $this->service->showBox($box),

        ]);
    }

    /**
     * @param BoxesRequest $request
     *
     * @param Box $box
     *
     * @return JsonResponse
     */
    public function update(BoxesRequest $request, Box $box): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The box was successfully updated.',

            'box' => $this->repository->updateBox($box, $this->service->updateBox($request)),
        ]);
    }

    /**
     * @param Box $box
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteBox($id);

        if(!$id)
        {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete box, please try again later.',
            ]);
        }

        $this->repository->deleteBox($id);

        return Json::sendJsonWith200([
            'message' => 'The box deleted successfully.',
        ]);
    }
}

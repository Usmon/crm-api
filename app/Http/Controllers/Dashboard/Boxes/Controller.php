<?php

namespace App\Http\Controllers\Dashboard\Boxes;

use App\Models\Box;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Boxes as BoxesRequest;

use App\Logic\Dashboard\CRUD\Services\Boxes as BoxesService;

use App\Logic\Dashboard\CRUD\Repositories\Boxes as BoxesRepository;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

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
        if(! Gate::check('Boxes')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

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
        if(! Gate::check('Boxes')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

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
        if(! Gate::check('Boxes')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        return Json::sendJsonWith200([
            'box' => $this->service->showBox($box),

        ]);
    }

    /**
     * @param int $order_id
     *
     * @return JsonResponse
     */
    public function getBoxes(int $order_id): JsonResponse
    {
        return Json::sendJsonWith200([
            'boxes' => $this->service->showBoxes($this->repository->getBoxesByOrder($order_id))
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
        if(! Gate::check('Boxes')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The box was successfully updated.',

            'box' => $this->repository->updateBox($box, $this->service->updateBox($request)),
        ]);
    }

    /**
     * @param int|int[] $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if(! Gate::check('Boxes')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

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

    /**
     * @param BoxesRequest $request
     *
     * @return JsonResponse
     */
    public function setStatus(BoxesRequest $request): JsonResponse
    {
        $box = Box::find($request->json('box_id'));

        $box->update([
            'status_id' => $request->json('status_id')
        ]);

        $box->histories()->create([
            'model_id' => $box->id,

            'status_id' => $box->status_id,

            'seq' => 0,

            'model' => Box::class,

            'creator_id' => auth()->user()->id
        ]);

        return Json::sendJsonWith200([
            'message' => 'The box successfully updated.',
        ]);
    }

    public function getShipments(int $id)
    {
        return Json::sendJsonWith200([
            'boxes' => $this->service->getShipments($this->repository->getShipments($id)),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function boxesFree(BoxesRequest $request)
    {
//        return Json::sendJsonWith200([
//            'boxes' => $this->service->boxesFree($this->repository->boxesFree()),
//        ]);

        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getAllSorts($request),

            'boxes' => $this->service->boxesFree($this->repository->boxesFree(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request)
            ))
        ]);
    }
}

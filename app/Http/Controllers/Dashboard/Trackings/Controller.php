<?php

namespace App\Http\Controllers\Dashboard\Trackings;

use App\Helpers\Json;

use App\Models\Tracking;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Trackings as TrackingsRequest;

use App\Logic\Dashboard\CRUD\Services\Trackings as TrackingsService;

use App\Logic\Dashboard\CRUD\Repositories\Trackings as TrackingsRepository;

final class Controller extends Controllers
{
    /**
     * @var TrackingsService
     */
    protected $service;

    /**
     * @var TrackingsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param TrackingsService $service
     *
     * @param TrackingsRepository $repository
     */
    public function __construct(TrackingsService $service, TrackingsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param TrackingsRequest $request
     *
     * @return JsonResponse
     */
    public function index(TrackingsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'trackings' => $this->service->getTrackings($this->repository->getTrackings(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request))),
        ]);
    }

    /**
     * @param TrackingsRequest $request
     *
     * @return JsonResponse
     */
    public function store(TrackingsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The tracking was successfully created.',

            'tracking' => $this->repository->storeTracking($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Tracking $tracking
     *
     * @return JsonResponse
     */
    public function show(Tracking $tracking): JsonResponse
    {
        return Json::sendJsonWith200([
            'tracking' => $this->service->showTracking($tracking),
        ]);
    }

    /**
     * @param TrackingsRequest $request
     *
     * @param Tracking $tracking
     *
     * @return JsonResponse
     */
    public function update(TrackingsRequest $request, Tracking $tracking): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The tracking was successfully updated.',

            'tracking' => $this->repository->updateTracking($tracking, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteTracking($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete tracking, parameters does not match.',
            ]);
        }

        $this->repository->deleteTracking($id);

        return Json::sendJsonWith200([
            'message' => 'The tracking was successfully deleted.',
        ]);
    }
}

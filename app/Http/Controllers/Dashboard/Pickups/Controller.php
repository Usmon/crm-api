<?php

namespace App\Http\Controllers\Dashboard\Pickups;

use App\Models\Order;
use App\Models\Pickup;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Pickups as PickupsRequest;

use App\Logic\Dashboard\CRUD\Services\Pickups as PickupsService;

use App\Logic\Dashboard\CRUD\Repositories\Pickups as PickupsRepository;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

final class Controller extends Controllers
{
    /**
     * @var PickupsService
     */
    protected $service;

    /**
     * @var PickupsRepository
     */
    protected $repository;

    /**
     * @param PickupsService $service
     *
     * @param PickupsRepository $repository
     *
     * @return void
     */
    public function __construct(PickupsService $service, PickupsRepository $repository)
    {
        $this->checkPermission('Pickups');

        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param PickupsRequest $request
     *
     * @return JsonResponse
     */
    public function index(PickupsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'pickups' => $this->service->getPickups($this->repository->getPickups(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request)),
            ),
        ]);
    }

    /**
     * @param PickupsRequest $request
     *
     * @return JsonResponse
     */
    public function store(PickupsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The pickup was succesfully created.',

            'pickup' => $this->repository->storePickup($this->service->createPickup($request)),
        ]);
    }

    /**
     * @param Pickup $pickup
     *
     * @return JsonResponse
     */
    public function show(Pickup $pickup): JsonResponse
    {
        return Json::sendJsonWith200([
            'pickup' => $this->service->showPickup($pickup),
        ]);
    }

    /**
     * @param PickupsRequest $request
     *
     * @param Pickup $pickup
     *
     * @return JsonResponse
     */
    public function update(PickupsRequest $request, Pickup $pickup): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The pickup was successfully updated.',

            'pickup' => $this->repository->updatePickup($pickup, $this->service->updatePickup($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deletePickup($id);

        if(!$id)
        {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete pickup, please try again later.',
            ]);
        }

        $this->repository->deletePickup($id);

        return Json::sendJsonWith200([
            'message' => 'The pickup deleted successfully',
        ]);
    }

    public function updateShow(int $id)
    {
        return Json::sendJsonWith200([
            'pickup' => $this->service->updateShow($this->repository->updateShow($id)),
        ]);
    }

    public function updateStatus(int $id, PickupsRequest $request)
    {
        return Json::sendJsonWith200([
            'message' => 'Pickup status was successfully updated.',

            'pickup' => $this->repository->updateStatus($id, $this->service->updateStatus($request)),
        ]);
    }

    /**
     * @param PickupsRequest $request
     *
     * @return JsonResponse
     */
    public function getEmptyTimes(PickupsRequest $request)
    {
        //Sorry for bad CODES

        $date = $request->json('date') ?? $request->get('date');
        $type = $request->json('type') ?? $request->get('type');

        $pickups = Order::whereDate('type->date->from', '=', $date)->where('type->index', '=', $type)->get();

        $times = [
            '08',
            '09',
            '10',
            '11',
            '12',
            '13',
            '14',
            '15',
            '16',
            '17',
            '18',
            '19',
        ];

        foreach ($pickups as $pickup) {
            $hour = Carbon::parse($pickup->type['date']['from'])->format('H');
            $exist = array_search($hour, $times);
            if ($exist !== false) {
                unset($times[$exist]);
            }
        }

        $times = collect($times)->transform(function ($time) use($date) {
            $formatted = Carbon::parse($date.' '.$time.':00');
            $from = clone $formatted;
            $formatted->addHour();
            return [
                'value' => $from->format('H:i').' - '.$formatted->format('H:i'),

                'from' => $from->format('Y-m-d H:i:s'),

                'to' => $formatted->format('Y-m-d H:i:s')
            ];
        });

        return Json::sendJsonWith200(['times' => $times->values()]);
    }
}

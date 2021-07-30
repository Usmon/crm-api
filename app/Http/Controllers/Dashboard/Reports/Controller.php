<?php

namespace App\Http\Controllers\Dashboard\Reports;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use App\Logic\Dashboard\Report\Requests\ReportRequest;

use App\Logic\Dashboard\Report\Services\ReportService;

use App\Http\Controllers\Controller as AbstractController;

use App\Logic\Dashboard\Report\Repositories\ReportRepository;

/**
 * Class Controller
 *
 * @package App\Http\Controllers\Dashboard\Reports
 */
final class Controller extends AbstractController
{
    /**
     * @var ReportService
     */
    private ReportService $service;

    private ReportRepository $repository;

    public function __construct(ReportService $service, ReportRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param ReportRequest $request
     *
     * @return JsonResponse
     */
    public function userProfile(ReportRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getOnlyFilters($request),

            'report' => $this->repository->corporateUserReport($this->service->getUserCredentials($request))
        ]);
    }

    /**
     * @param ReportRequest $request
     *
     * @return JsonResponse
     */
    public function pickupCalendar(ReportRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'pickups' => $this->service->getPickupCalendarData($this->repository->pickupCalendarReport($this->service->getPickupCalendarFilter($request)))
        ]);
    }
}

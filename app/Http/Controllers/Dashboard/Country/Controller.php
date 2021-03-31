<?php

namespace App\Http\Controllers\Dashboard\Country;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Services\Countries as CountryService;

use App\Logic\Dashboard\CRUD\Repositories\Countries as CountryRepository;

use Illuminate\Http\JsonResponse;

class Controller extends Controllers
{
    /**
     * @var CountryService
     */
    public $service;

    /**
     * @var CountryRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param CountryService $service
     *
     * @param CountryRepository $repository
     */
    public function __construct(CountryService $service, CountryRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return Json::sendJsonWith200([
            'countries' => $this->service->getAll($this->repository->getRegions())
        ]);
    }
}

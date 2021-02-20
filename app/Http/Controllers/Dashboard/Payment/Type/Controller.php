<?php

namespace App\Http\Controllers\Dashboard\Payment\Type;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Repositories\PaymentTypes as Repository;
use App\Logic\Dashboard\CRUD\Services\PaymentTypes as Service;
use Illuminate\Http\Request;
use App\Helpers\Json;

/**
 * Class Controller
 * @package App\Http\Controllers\Payment\Type
 */
class Controller extends Controllers
{
    /**
     * @var
     */
    protected $repository;

    /**
     * @var
     */
    protected $service;

    /**
     * Controller constructor.
     *
     * @param Service $service
     *
     * @poram Repository $repository
     *
     * @return void
     */
    public function __construct(Service $service, Repository $repository)
    {
        $this->repository = $repository;

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return Json::sendJsonWith200([
            'types' => $this->service->getItems($this->repository->getTypes())
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        //@todo get item
    }
}

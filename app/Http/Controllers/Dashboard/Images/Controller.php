<?php

namespace App\Http\Controllers\Dashboard\Images;

use App\Helpers\Json;

use App\Models\Sender;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Images as ImagesRequest;

use App\Logic\Dashboard\CRUD\Services\Images as ImagesService;

use App\Logic\Dashboard\CRUD\Repositories\Images as ImagesRepository;

final class Controller extends Controllers
{
    /**
     * @var ImagesService
     */
    protected $service;

    /**
     * @var ImagesRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param ImagesService $service
     *
     * @param ImagesRepository $repository
     */
    public function __construct(ImagesService $service, ImagesRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param ImagesRequest $request
     *
     * @return JsonResponse
     */
    public function store(ImagesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The image was successfully saved.',

            'path' => $this->repository->storeImage($this->service->storeCredentials($request)),
        ]);
    }
}

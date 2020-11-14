<?php

namespace App\Http\Controllers;

use App\Helper\Json;

use Illuminate\Http\JsonResponse;

final class App extends Controller
{
    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return Json::sendJsonWith200([
            'app' => [
                'name' => config('app.name'),
                'version' => config('app.version'),
            ],
        ]);
    }
}

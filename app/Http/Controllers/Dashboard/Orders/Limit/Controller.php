<?php

namespace App\Http\Controllers\Dashboard\Orders\Limit;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use App\Logic\Dashboard\CRUD\Requests\Limit as LimitRequest;

use App\Http\Controllers\Controller as Controllers;

/**
 * Class Controller
 *
 * @package App\Http\Controllers\Dashboard\Orders\Limit
 */
class Controller extends Controllers
{

    /**
     * @param LimitRequest $request
     *
     * @return JsonResponse
     */
    public function checkSender(LimitRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The customer quarter checked.'
        ]);
    }
}

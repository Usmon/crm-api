<?php

namespace App\Http\Controllers;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Gate;

use Illuminate\Routing\Controller as Routing;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends Routing
{
    use AuthorizesRequests;
    use ValidatesRequests;
    use DispatchesJobs;

    /**
     * @param string $permission
     *
     * @return mixed
     * */
    protected function checkPermission(string $permission)
    {
        if(! Gate::check($permission)){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as Routing;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends Routing
{
    use AuthorizesRequests;
    use ValidatesRequests;
    use DispatchesJobs;
}

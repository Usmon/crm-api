<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

final class TrustProxies extends Middleware
{
    /**
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}

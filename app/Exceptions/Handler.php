<?php

namespace App\Exceptions;

use Throwable;

use App\Helpers\Json;

use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Foundation\Exceptions\Handler as Exceptions;

use Symfony\Component\HttpFoundation\Response;

final class Handler extends Exceptions
{
    /**
     * @param Request $request
     *
     * @param Throwable $e
     *
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return Json::sendJsonWith422([
                'message' => $e->errors(),
            ]);
        }

        if ($e instanceof ModelNotFoundException) {
            return Json::sendJsonWith404([
                'message' => $e->getMessage(),
            ]);
        }

        return parent::render($request, $e);
    }
}

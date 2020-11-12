<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

final class Json
{
    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    public static function sendJsonWith200(array $data): JsonResponse
    {
        return self::sendJson($data, 200, true);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    public static function sendJsonWith201(array $data): JsonResponse
    {
        return self::sendJson($data, 201, true);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    public static function sendJsonWith400(array $data): JsonResponse
    {
        return self::sendJson($data, 400, false);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    public static function sendJsonWith401(array $data): JsonResponse
    {
        return self::sendJson($data, 401, false);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    public static function sendJsonWith404(array $data): JsonResponse
    {
        return self::sendJson($data, 404, false);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    public static function sendJsonWith422(array $data): JsonResponse
    {
        return self::sendJson($data, 422, false);
    }

    /**
     * @param array $data
     * @param int $status
     * @param bool $success
     *
     * @return JsonResponse
     */
    protected static function sendJson(array $data, int $status, bool $success): JsonResponse
    {
        $response = [
            'success' => $success,
            'data' => $data ?? [],
        ];

        return Response::json($response, $status);
    }
}

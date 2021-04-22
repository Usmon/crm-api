<?php


namespace App\Integrations\Fedex\Request;

use Illuminate\Support\Facades\Http;

/**
 * Class Prepare
 *
 * @package App\Integrations\Fedex\Request
 *
 * @method protected send(string $url, array $params)
 */
abstract class Prepare
{
    /**
     * @param string $url
     *
     * @param array $params
     *
     * @return array|mixed
     */
    protected function send(string $url, array $params)
    {
        return Http::post($url, $params)->json();
    }

}

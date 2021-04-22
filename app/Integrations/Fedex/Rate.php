<?php


namespace App\Integrations\Fedex;

use App\Integrations\Fedex\Request\Prepare;

/**
 * Class Rate
 *
 * @package App\Integrations\Fedex
 *
 * @method protected send(string $url, array $params)
 */
final class Rate extends Prepare
{
    /**
     * @var string
     */
    private $url = 'https://services.silkroadexp.com/fedex/rate';

    /**
     * @param array $parameters
     *
     * @return array|mixed
     */
    public function getResult(array $parameters)
    {
        return $this->send($this->url, $parameters);
    }
}

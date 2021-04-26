<?php


namespace App\Integrations\Fedex;

use App\Integrations\Fedex\Request\Prepare;

/**
 * Class Ship
 *
 * @package App\Integrations\Fedex
 */
class Ship extends Prepare
{
    /**
     * @var string
     */
    private $url = 'https://services.silkroadexp.com/fedex/ship';

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

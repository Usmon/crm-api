<?php


namespace App\Helpers;

use Carbon\Carbon;

use App\Models\Order;

/**
 * Class LimitChecker
 *
 * @package App\Helpers
 */
final class LimitChecker
{
    /**
     * @var array
     */
    public $quarter = [];

    /**
     * @const float
     */
    const LIMIT = 1000;

    /**
     * @return void
     */
    public function __construct()
    {
        $carbon = new Carbon;

        $this->quarter = [
            $carbon->firstOfQuarter()->toDateString(),

            $carbon->lastOfQuarter()->toDateString()
        ];
    }

    /**
     * @param string $attribute
     *
     * @param int $value
     *
     * @return float
     */
    public function limit(string $attribute, int $value): float
    {
        return self::LIMIT - $this->sum($attribute, $value);
    }

    /**
     * @param string $attribute
     *
     * @param int $value
     *
     * @return bool
     */
    public function check(string $attribute, int $value): bool
    {
        return self::sum($attribute, $value) < self::LIMIT;
    }

    /**
     * @param string $attribute
     *
     * @param int $value
     */
    public function sum(string $attribute, int $value): float
    {
        return Order::where($attribute, $value)
                    ->whereBetween('created_at', $this->quarter)
                    ->sum('price_total');
    }
}

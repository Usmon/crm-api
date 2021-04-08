<?php

namespace App\Rules;

use Carbon\Carbon;

use App\Models\Order;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class CustomerLimit
 *
 * @package App\Rules
 */
final class CustomerLimit implements Rule
{
    /**
     * @const integer
     */
    const LIMIT = 1000;

    /**
     * @var array
     */
    private $quarter = [];

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
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $this->checker($attribute, $value);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute out of limit.';
    }

    /**
     * @param $attribute
     *
     * @param $value
     *
     * @return bool
     */
    public function checker($attribute, $value): bool
    {
        return Order::where($attribute, $value)
                    ->whereBetween('created_at', $this->quarter)
                    ->sum('price_total')
                    < self::LIMIT;
    }
}

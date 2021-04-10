<?php

namespace App\Rules;

use App\Helpers\LimitChecker;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class CustomerLimit
 *
 * @package App\Rules
 */
final class CustomerLimit implements Rule
{

    /**
     * @param string $attribute
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return (new LimitChecker())->check($attribute, $value);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute out of limit.';
    }


}

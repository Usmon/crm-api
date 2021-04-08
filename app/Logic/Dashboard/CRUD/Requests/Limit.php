<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use App\Rules\CustomerLimit;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Limit
 *
 * @package App\Logic\Dashboard\CRUD\Requests
 */
final class Limit extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'recipient_id' => [
                'required',

                'integer',

                Rule::exists('recipients', 'id'),

                new CustomerLimit()
            ]
        ];
    }
}

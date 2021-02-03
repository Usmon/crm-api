<?php

namespace App\Logic\Password\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Token extends FormRequest
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
        $rules = [
            'password' => [
                'token' => [
                    'required',

                    'string',

                    Rule::exists('users', 'reset_token')
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

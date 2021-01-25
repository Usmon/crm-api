<?php

namespace App\Logic\Password\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Reset extends FormRequest
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

                'password' => [
                    'required',

                    'string',

                    'min:8',

                    'max:255',

                    'confirmed',
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

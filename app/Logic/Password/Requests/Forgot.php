<?php

namespace App\Logic\Password\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Forgot extends FormRequest
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
                'custom_url' => [
                    'required',

                    'string'
                ],

                'email' => [
                    'required',

                    'email',

                    Rule::exists('users', 'email')
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

<?php

namespace App\Logic\Auth\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Register extends FormRequest
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
            'login' => [
                'required',

                'string',

                'max:255',

                Rule::unique('users', 'login'),
            ],

            'email' => [
                'required',

                'email',

                'string',

                'max:255',

                Rule::unique('users', 'email'),
            ],

            'password' => [
                'required',

                'string',

                'min:8',

                'max:255',

                'confirmed',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests\Auth;

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

                'unique:users',
            ],

            'email' => [
                'required',

                'email',

                'string',

                'max:255',

                'unique:users',
            ],

            'password' => [
                'required',

                'string',

                'min:8',

                'confirmed',
            ],
        ];
    }
}

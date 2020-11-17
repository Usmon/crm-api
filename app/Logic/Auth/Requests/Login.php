<?php

namespace App\Logic\Auth\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Login extends FormRequest
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
                Rule::requiredIf($this->json('email') === '' ?? $this->json('email') === null),

                'string',

                'max:255',

                Rule::exists('users', 'login'),
            ],

            'email' => [
                Rule::requiredIf($this->json('login') === '' ?? $this->json('login') === null),

                'email',

                'string',

                'max:255',

                Rule::exists('users', 'email'),
            ],

            'password' => [
                'required',

                'string',

                'max:255',
            ],
        ];
    }
}

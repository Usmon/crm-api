<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class ProfileUpdate extends FormRequest
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
            'full_name' => [
                'required',

                'string',

                'max:100'
            ],

            'email' => [
                'required',

                'email',

                Rule::unique('users', 'email')->ignore($this->user()->id)
            ],

            'photo' => [
                'required',

                'url',
            ],

            'phones' => [
                'required',

                'array'
            ],

            'phones.*' => [
                'required',

                'string',

                Rule::unique('phones', 'phone')->ignore($this->user()->id, 'user_id')
            ],

            'login' => [
                'required',

                'string',

                Rule::unique('users', 'login')->ignore($this->user()->id)
            ],

            'password' => [
                'nullable',

                'string',

                'min:6',

                'confirmed'
            ]
        ];
    }
}

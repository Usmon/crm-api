<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Addresses extends FormRequest
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
            'dashboard.addresses.index' => [
                'search' => [
                    'nullable',

                    'string',

                    'max:255',
                ],

                'date' => [
                    'nullable',

                    'array',
                ],

                'date.from' => [
                    'nullable',

                    'date',

                    'before:now',
                ],

                'date.to' => [
                    'nullable',

                    'date',

                    'after:date.from',
                ],

                'user_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id'),
                ],

                'city_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('cities','id'),
                ],

                'first_address' => [
                    'nullable',

                    'string',
                ],

                'second_address' => [
                    'nullable',

                    'string',
                ],

                'user' => [
                    'nullable',

                    'string',
                ],

                'sort.*' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.addresses.store' => [
                'user_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id')
                ],

                'city_id' => [
                    'required',

                    'integer',

                    Rule::exists('cities', 'id')
                ],

                'first_address' => [
                    'required',

                    'string',
                ],

                'second_address' => [
                    'required',

                    'string',
                ],


            ],

            'dashboard.addresses.update' => [
                'user_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id')
                ],

                'city_id' => [
                    'required',

                    'integer',

                    Rule::exists('cities', 'id')
                ],

                'first_address' => [
                    'required',

                    'string',
                ],

                'second_address' => [
                    'required',

                    'string',
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

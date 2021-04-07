<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Recipients extends FormRequest
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
            'dashboard.recipients.index' => [
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

                'customer_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id'),
                ],

                'customer' => [
                    'nullable',

                    'string',
                ],

                'sort.*' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.recipients.store' => [
                'user' => [
                    'required',

                    'array',
                ],

                'user.first_name' => [
                    'required',

                    'string'
                ],

                'user.last_name' => [
                    'required',

                    'string'
                ],

                'user.middle_name' => [
                    'required',

                    'string'
                ],

//                'user.email' => [
//                    'required',
//
//                    'email',
//
//                    Rule::unique('users', 'email')
//                ],
//
//                'user.login' => [
//                    'required',
//
//                    'string',
//
//                    Rule::unique('users', 'login')
//                ],
//
//                'user.password' => [
//                    'required',
//
//                    'min:8',
//                ],

                'phone' => [
                    'required',

                    'string',

                    Rule::unique('phones', 'phone')
                ],

                'address' => [
                    'required',

                    'array'
                ],

                "address.city_id" => [
                    'required',

                    'integer',

                    Rule::exists('cities', 'id')
                ],

                'address.first_address' => [
                    'required',

                    'string'
                ],

                'address.second_address' => [
                    'nullable',

                    'string'
                ]
            ],

            'dashboard.recipients.update' => [
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id')
                ],

            ],

            'dashboard.recipients.phone.check' => [
                'phone' => [
                    'required',

                    'string',

                    Rule::exists('phones', 'phone')
                ],
            ]

        ];

        return $rules[$this->route()->getName()];
    }
}

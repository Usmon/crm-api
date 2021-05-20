<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use App\Models\Phone;

use App\Models\Sender;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Senders extends FormRequest
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
            'dashboard.senders.sender.index' => [
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

                    Rule::exists('customers','id'),
                ],

                'sort.*' => [
                    'nullable',

                    'string',
                ],

            ],

            'dashboard.senders.sender.store' => [
                'user' => [
                    'required',

                    'array',
                ],

                'user.full_name' => [
                    'required',

                    'string'
                ],

                'user.first_name' => [
                    'nullable',

                    'string'
                ],

                'user.last_name' => [
                    'nullable',

                    'string'
                ],

                'user.middle_name' => [
                    'nullable',

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

            'dashboard.senders.sender.update' => [
                'user' => [
                    'required',

                    'array',
                ],

                'user.full_name' => [
                    'required',

                    'string'
                ],

                'user.first_name' => [
                    'nullable',

                    'string'
                ],

                'user.last_name' => [
                    'nullable',

                    'string'
                ],

                'user.middle_name' => [
                    'nullable',

                    'string'
                ],

                'user.email' => [
                    'required',

                    'email',

                    Rule::unique('users', 'email')->ignore($this->route('sender')->customer->user_id ?? 0)
                ],

                'phones' => [
                    'required',

                    'array'
                ],

                'phones.*' => [
                    'required',

                    'string',
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
                ],

                'limit' => [
                    'required',

                    'numeric'
                ],

                'debt' => [
                    'required',

                    'numeric'
                ],

                'balance' => [
                    'required',

                    'numeric'
                ],
            ],

            'dashboard.senders.phone.check' => [
                'phone' => [
                    'required',

                    'string',

                    Rule::exists('phones', 'phone')
                ],
            ],

            'dashboard.senders.phone.search' => [
                'phone' => [
                    'required',

                    'string'
                ],
            ]
        ];

        return $rules[$this->route()->getName()];
    }
}

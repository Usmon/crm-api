<?php

namespace App\Logic\Dashboard\CRUD\Requests;

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

                'region' => [
                    'nullable',

                    'string',
                ],

                'city' => [
                    'nullable',

                    'string',
                ],

                'address' => [
                    'nullable',

                    'string',
                ],

                'region_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('regions','id'),
                ],

                'city_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('cities','id'),
                ],

                'address_id' => [
                    'nullable',

                    'string',

                    Rule::exists('addresses','id'),
                ],

                'sort.*' => [
                    'nullable',

                    'string',
                ],

            ],

            'dashboard.senders.sender.store' => [
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('customers', 'id'),
                ],

                'region_id' => [
                    'required',

                    'integer',

                    Rule::exists('regions','id'),
                ],

                'city_id' => [
                    'required',

                    'integer',

                    Rule::exists('cities','id'),
                ],

                'permissions' => [
                    'required',

                    'array',
                ],

                'permissions.*' => [
                    'required',

                    'integer',

                    Rule::exists('permissions', 'id'),
                ],
            ],

            'dashboard.senders.sender.update' => [
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('customers', 'id'),
                ],

                'region_id' => [
                    'required',

                    'integer',

                    Rule::exists('regions','id'),
                ],

                'city_id' => [
                    'required',

                    'integer',

                    Rule::exists('cities','id'),
                ],

                'permissions' => [
                    'required',

                    'array',
                ],

                'permissions.*' => [
                    'required',

                    'integer',

                    Rule::exists('permissions', 'id'),
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

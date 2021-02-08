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

                'customer_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('customers','id'),
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

                'sort.*' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.addresses.store' => [
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('customers', 'id')
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
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('customers', 'id')
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

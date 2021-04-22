<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class FedexOrders extends FormRequest
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
            'dashboard.fedex-orders.index' => [
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

                'staff_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id'),
                ],
            ],

            'dashboard.fedex-orders.store' => [
                'price' => [
                    'required',

                    'numeric',

                    'min:0',
                ],

                'discount_price' => [
                    'required',

                    'numeric',

                    'min:0',
                ],

                'service_type' => [
                    'string',

                    'in:ground'
                ],

                'status' => [
                    'string',

                    'in:ground,pending,arrived'
                ],

                'staff_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
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

            'dashboard.fedex-orders.update' => [
                'price' => [
                    'required',

                    'numeric',

                    'min:0',
                ],

                'discount_price' => [
                    'required',

                    'numeric',

                    'min:0',
                ],

                'service_type' => [
                    'string',

                    'in:ground'
                ],

                'status' => [
                    'string',

                    'in:ground,pending,arrived'
                ],

                'staff_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
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

            'dashboard.fedex-orders.rate' => [
                'address_id' => [
                    'required',

                    'integer',

                    Rule::exists('addresses', 'id')
                ],

                'boxes' => [
                    'required',

                    'array'
                ],

                'boxes.*.weight.value' => [
                    'required',

                    'integer',
                ]
            ]
        ];

        return $rules[$this->route()->getName()];
    }
}

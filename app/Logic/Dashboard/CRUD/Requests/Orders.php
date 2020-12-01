<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Orders extends FormRequest
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
            'dashboard.orders.index' => [
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
            ],

            'dashboard.orders.store' => [
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

                'fedex_order_id' => [
                    'required',

                    'integer',

                    Rule::exists('fedex_orders', 'id'),
                ],

                'pickup_id' => [
                    'required',

                    'integer',

                    Rule::exists('pickups', 'id'),
                ],

                'shipment_id' => [
                    'required',

                    'integer',

                    Rule::exists('shipments', 'id'),
                ],

                'price' => [
                    'required',

                    'numeric',

                    'min:0',
                ],

                'payed_price' => [
                    'required',

                    'numeric',

                    'min:0',
                ],

                'status' => [
                    'required',

                    'string',

                    'in:created,picked_up,waiting,pending,shipping,shipped,delivering,delivered,canceled'
                ],

                'payment_status' => [
                    'required',

                    'string',

                    'in:payed,debt'
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

            'dashboard.orders.update' => [
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

                'fedex_order_id' => [
                    'required',

                    'integer',

                    Rule::exists('fedex_orders', 'id'),
                ],

                'pickup_id' => [
                    'required',

                    'integer',

                    Rule::exists('pickups', 'id'),
                ],

                'shipment_id' => [
                    'required',

                    'integer',

                    Rule::exists('shipments', 'id'),
                ],

                'price' => [
                    'required',

                    'numeric',

                    'min:0',
                ],

                'payed_price' => [
                    'required',

                    'numeric',

                    'min:0',
                ],

                'status' => [
                    'required',

                    'string',

                    'in:created,picked_up,waiting,pending,shipping,shipped,delivering,delivered,canceled'
                ],

                'payment_status' => [
                    'required',

                    'string',

                    'in:payed,debt'
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

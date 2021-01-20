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
            'dashboard.orders.order.index' => [
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

                'status' => [
                    'nullable',

                    'string',
                ],

                'payment_status' => [
                    'nullable',

                    'string',
                ],

                'price' => [
                    'nullable',

                    'array',
                ],

                'payed_price' => [
                    'nullable',

                    'array',
                ],

                'staff_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id'),
                ],

                'customer_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id'),
                ],

                'fedex_order_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('fedex_orders','id'),
                ],

                'pickup_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('pickups','id'),
                ],

                'shipment_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('shipments','id'),
                ],

                'staff' => [
                    'nullable',

                    'string',
                ],

                'customer' => [
                    'nullable',

                    'string',
                ],

                'pickup' => [
                    'nullable',

                    'string',
                ],

                'shipment' => [
                    'nullable',

                    'string',
                ],

                'total_boxes' => [
                    'nullable',

                    'array',
                ],

                'total_weight_boxes' => [
                    'nullable',

                    'array',
                ],

                'total_delivered_boxes' =>[
                    'nullable',

                    'array',
                ],
            ],

            'dashboard.orders.order.store' => [
                'sender_id' => [
                    'required',
                    
                    'integer',

                    Rule::exists('senders', 'id')
                ],

                'recipient_id' => [
                    'required',
                    
                    'integer',

                    Rule::exists('recipients', 'id')
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

                'products' => [
                    'required',
                    
                    'array',
                ],

                'products.*.name' => [
                    'required',

                    'string'
                ],

                'products.*.quantity' => [
                    'required',

                    'numeric'
                ],

                'products.*.price' => [
                    'required',

                    'numeric'
                ],

                'products.*.weight' => [
                    'required',

                    'numeric'
                ],

                'products.*.type_weight' => [
                    'required',

                    'string',

                    Rule::in(['lb', 'kg'])
                ],

                'products.*.note' => [
                    'string',
                ],

                'payment_status' => [
                    'required',

                    'string',

                    'in:payed,debt'
                ],

            ],

            'dashboard.orders.order.update' => [
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

                    'min:0'
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

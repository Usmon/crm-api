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

                'status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id')
                ],

                'payment_status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id')
                ],

                'type' => [
                    'required'
                ],

                'type.index' => [
                    'required'
                ],

                'type.date' => [
                    'required'
                ],

                'type.date.from' => [
                    'required'
                ],

                'type.date.to' => [
                    'required'
                ],

                'type.index' => [
                    'required',

                    'string',

                    'in:pickup,fedex,self_delivery',
                ],

                'boxes' => [
                    'required',

                    'array'
                ],

                'boxes.*.products' => [
                    'required',
                    
                    'array',
                ],

                'boxes.*.products.*.name' => [
                    'required',

                    'string'
                ],

                'boxes.*.products.*.quantity' => [
                    'required',

                    'numeric'
                ],

                'boxes.*.products.*.price' => [
                    'required',

                    'numeric'
                ],

                'boxes.*.products.*.weight' => [
                    'required',

                    'numeric'
                ],

                'boxes.*.products.*.type_weight' => [
                    'required',

                    'string',

                    Rule::in(['lb', 'kg'])
                ],

                'boxes.*.products.*.note' => [
                    'string',
                ],

                'boxes.*.products.*.image' => [
                    'string',
                ],

                'boxes.*.products.*.image' => [
                    'string',
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

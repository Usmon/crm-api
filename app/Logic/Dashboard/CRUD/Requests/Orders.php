<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

use App\Logic\Dashboard\CRUD\Services\Statuses;

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
//        dd($this->route()->parameter('id'));
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

                'status_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('statuses', 'id')
                ],

                'payment_status_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('statuses', 'id')
                ],

                'partner_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('partners', 'id')
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
                ],

                'additional_weight' => [
                    'nullable',

                    'numeric',
                ],

                'price_additional' => [
                    'nullable',

                    'numeric',
                ],

                'price_insurance' => [
                    'nullable',

                    'numeric',
                ],

                'price_payed' => [
                    'nullable',

                    'numeric',
                ],

                'payment_type_id' => [
                    'array',
                ],

                'payment_type_id.*' => [
                    'nullable',

                    'integer',

                    Rule::exists('payment_types', 'id'),
                ],

                'type' => [
                    'required'
                ],

                'type.index' => [
                    'required',

                    'string',

                    'in:pickup,fedex,self_delivery',
                ],

                'type.date' => [
                    'required_if:type.index,pickup,fedex'
                ],

                'type.date.from' => [
                    'required_if:type.index,pickup,fedex'
                ],

                'type.date.to' => [
                    'required_if:type.index,pickup,fedex'
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
                    'nullable',

                    'string'
                ],

                'boxes.*.products.*.image' => [
                    'nullable',

                    'string',
                ]

            ],

            'dashboard.orders.order.update' => [
                'fedex_order_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('fedex_orders', 'id'),
                ],

                'pickup_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('pickups', 'id'),
                ],

                'shipment_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('shipments', 'id'),
                ],

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

//                'status_id' => [
//                    'required',
//
//                    'integer',
//
//                    Rule::exists('statuses', 'id')
//                ],

//                'payment_status_id' => [
//                    'required',
//
//                    'integer',
//
//                    Rule::exists('statuses', 'id')
//                ],

                'additional_weight' => [
                    'numeric',
                ],

                'price_additional' => [
                    'numeric',
                ],

                'price_insurance' => [
                    'numeric',
                ],

                'price_payed' => [
                    'numeric',
                ],

                'payment_type_id' => [
                    'array',
                ],

                'payment_type_id.*' => [
                    'required',

                    'integer',

                    Rule::exists('payment_types', 'id'),
                ],

                'type' => [
                    'required'
                ],

                'type.date' => [
                    'required'
                ],

                'type.date.from' => [
                    'required',

                    'date_format:Y-m-d H:i:s'
                ],

                'type.date.to' => [
                    'required',

                    'date_format:Y-m-d H:i:s'
                ],

                'type.index' => [
                    'required',

                    'string',

                    'in:pickup,fedex,self_delivery',
                ],

//                'payment_type_id' => [
//                    'required',
//
//                    'integer',
//
//                    Rule::exists('payment_types', 'id'),
//                ],
            ],

            'dashboard.orders.status-set' => [
                'status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id')->where('model', Statuses::ORDER)
                ],

                'order_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders', 'id')
                ]
            ],

            'dashboard.orders.status-payment-set' => [
                'payment_status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id')->where('model', Statuses::ORDER_PAYMENT)
                ],

                'order_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders', 'id')
                ]
            ],
        ];
//        dd($this->route()->getName());
        return $rules[$this->route()->getName()];
    }
}

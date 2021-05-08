<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use App\Models\Order;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Boxes extends FormRequest
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
            'dashboard.boxes.box.index' => [
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

                    'after:date.from'
                ],

                'pickup_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('pickups','id'),
                ],

                'order_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('orders','id'),
                ],

                'status_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('statuses','id'),
                ],

                'weight' => [
                    'nullable',

                    'array',
                ],

                'weight.from' => [
                    'nullable',

                    'numeric',
                ],

                'weight.to' => [
                    'nullable',

                    'numeric',
                ],

                'additional_weight' => [
                    'nullable',

                    'array',
                ],

                'additional_weight.from' => [
                    'nullable',

                    'numeric',
                ],

                'additional_weight.to' => [
                    'nullable',

                    'numeric',
                ],

                'status' => [
                    'nullable',

                    'string',
                ],

                'creator' => [
                    'nullable',

                    'string',
                ],

                'customer' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.boxes.box.store' => [
                'pickup_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('pickups', 'id'),
                ],

                'order_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('orders', 'id'),
                ],

                'delivery_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('deliveries', 'id'),
                ],

                'shipment_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('shipments', 'id'),
                ],

                'additional_weight' => [
                    'nullable',

                    'numeric',

                    'min:0',
                ],

                'note' => [
                    'required',

                    'string',
                ],

                'products' => [
                    'required',

                    'array',
                ],

                'products.*.name' => [
                    'required',

                    'string',
                ],

                'products.*.quantity' => [
                    'required',

                    'integer',
                ],

                'products.*.price' => [
                    'required',

                    'numeric',
                ],

                'products.*.weight' => [
                    'required',

                    'numeric',
                ],

                'products.*.type_weight' => [
                    'required',

                    'string',

                    'in:lb,kg',
                ],

                'products.*.note' => [
                    'required',

                    'string',
                ],

                'products.*.image' => [
                    'required',

                    'string',
                ],
            ],

            'dashboard.boxes.box.update' => [
                'pickup_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('pickups', 'id'),
                ],

                'order_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('orders', 'id'),
                ],

                'delivery_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('deliveries', 'id'),
                ],

                'shipment_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('shipments', 'id'),
                ],

                'additional_weight' => [
                    'nullable',

                    'numeric',

                    'min:0',
                ],

                'note' => [
                    'required',

                    'string',
                ],

                'products' => [
                    'required',

                    'array',
                ],

                'products.*.name' => [
                    'required',

                    'string',
                ],

                'products.*.quantity' => [
                    'required',

                    'integer',
                ],

                'products.*.price' => [
                    'required',

                    'numeric',
                ],

                'products.*.weight' => [
                    'required',

                    'numeric',
                ],

                'products.*.type_weight' => [
                    'required',

                    'string',

                    'in:lb,kg',
                ],

                'products.*.note' => [
                    'required',

                    'string',
                ],

                'products.*.image' => [
                    'required',

                    'string',
                ],
            ],

            'dashboard.boxes.set-status' => [
                'status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id')->where('model', Order::class)
                ],

                'box_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders', 'id')
                ]
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

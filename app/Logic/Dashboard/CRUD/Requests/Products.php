<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Products extends FormRequest
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
            'dashboard.products.index' => [
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

                'order_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('orders','id'),
                ],

                'name' => [
                    'nullable',

                    'string',
                ],

                'status' => [
                    'nullable',

                    'string',
                ],

                'quantity' => [
                    'nullable',

                    'array',
                ],

                'quantity.from' => [
                    'nullable',

                    'integer',
                ],

                'quantity.to' => [
                    'nullable',

                    'integer',
                ],

                'price' => [
                    'nullable',

                    'array',
                ],

                'price.from' => [
                    'nullable',

                    'numeric',
                ],

                'price.to' => [
                    'nullable',

                    'numeric',
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

                'type_weight' => [
                    'nullable',

                    'in:lb,kg'
                ],

                'note' => [
                    'nullable',

                    'string',
                ],

                'sort.*' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.products.store' => [
                'order_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders', 'id')
                ],

                'name' => [
                    'required',

                    'string',
                ],

                'status' => [
                    'required',

                    'in:created,waiting in office,at the office,shipment,transit,customs,tashkent,delivering,delivered'
                ],

                'quantity' => [
                    'required',

                    'integer',
                ],

                'price' => [
                    'required',

                    'numeric',
                ],

                'weight' => [
                    'required',

                    'numeric',
                ],

                'type_weight' => [
                    'required',

                    'in:lb,kg'
                ],

                'image' => [
                    'string',
                ],

                'note' => [
                    'required',

                    'string',
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

            'dashboard.products.update' => [
                'order_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders', 'id')
                ],

                'name' => [
                    'required',

                    'string',
                ],

                'status' => [
                    'required',

                    'in:created,waiting in office,at the office,shipment,transit,customs,tashkent,delivering,delivered'
                ],

                'quantity' => [
                    'required',

                    'integer',
                ],

                'price' => [
                    'required',

                    'numeric',
                ],

                'weight' => [
                    'required',

                    'numeric',
                ],

                'type_weight' => [
                    'required',

                    'in:lb,kg'
                ],

                'image' => [
                    'string',
                ],

                'note' => [
                    'required',

                    'string',
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

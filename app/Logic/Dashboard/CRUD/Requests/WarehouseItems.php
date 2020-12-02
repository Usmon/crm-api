<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class WarehouseItems extends FormRequest
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
            'dashboard.warehouse-items.index' => [
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

            'dashboard.warehouse-items.store' => [
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id')
                ],

                'shipment_id' => [
                    'required',

                    'integer',

                    Rule::exists('shipments', 'id'),
                ],

                'name' => [
                    'required',

                    'string'
                ],

                'init_quantity' =>[
                    'required',

                    'integer',

                    'min:0'
                ],

                'quantity' => [
                    'required',

                    'integer',

                    'min:0'
                ],

                'init_weight' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'weight' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'total_price' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'payed' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'note' => [
                    'required',

                    'string'
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

            'dashboard.warehouse-items.update' => [
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id')
                ],

                'shipment_id' => [
                    'required',

                    'integer',

                    Rule::exists('shipments', 'id'),
                ],

                'name' => [
                    'required',

                    'string'
                ],

                'init_quantity' =>[
                    'required',

                    'integer',

                    'min:0'
                ],

                'quantity' => [
                    'required',

                    'integer',

                    'min:0'
                ],

                'init_weight' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'weight' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'total_price' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'payed' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'note' => [
                    'required',

                    'string'
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

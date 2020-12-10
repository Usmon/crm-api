<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class FedexOrderItem extends FormRequest
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
            'dashboard.fedex-order-items.index' => [
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

                'fedex_order_id' => [
                    'nullable',

                    'integer',
                ],

                'weight' => [
                    'nullable',

                    'array',
                ],

                'width' => [
                    'nullable',

                    'array',
                ],

                'height' => [
                    'nullable',

                    'array',
                ],

                'length' => [
                    'nullable',

                    'array',
                ],

                'service_price' => [
                    'nullable',

                    'array',
                ],

                'label_file_name' => [
                    'nullable',

                    'string'
                ],

                'barcode' => [
                    'nullable',

                    'string'
                ],
            ],

            'dashboard.fedex-order-items.store' => [
                'fedex_order_id' => [
                    'required',

                    'integer',

                    Rule::exists('fedex_orders', 'id'),
                ],

                'weight' => [
                    'required',

                    'numeric'
                ],

                'width' => [
                    'required',

                    'integer'
                ],

                'height' => [
                    'required',

                    'integer'
                ],

                'length' => [
                    'required',

                    'integer'
                ],

                'service_price' => [
                    'required',

                    'numeric'
                ],

                'label_file_name' => [
                    'required',

                    'string'
                ],

                'barcode' => [
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

            'dashboard.fedex-order-items.update' => [
                'fedex_order_id' => [
                    'required',

                    'integer',

                    Rule::exists('fedex_orders', 'id'),
                ],

                'weight' => [
                    'required',

                    'numeric'
                ],

                'width' => [
                    'required',

                    'integer'
                ],

                'height' => [
                    'required',

                    'integer'
                ],

                'length' => [
                    'required',

                    'integer'
                ],

                'service_price' => [
                    'required',

                    'numeric'
                ],

                'label_file_name' => [
                    'required',

                    'string'
                ],

                'barcode' => [
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

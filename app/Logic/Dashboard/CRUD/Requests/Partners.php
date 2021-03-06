<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Partners extends FormRequest
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
            'dashboard.partners.index' => [
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

                'city_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('cities','id'),
                ],

                'name' => [
                    'nullable',

                    'string',
                ],

                'description' => [
                    'nullable',

                    'string',
                ],

                'address' => [
                    'nullable',

                    'string',
                ],

                'phone' => [
                    'nullable',

                    'string',
                ],

                'city' => [
                    'nullable',

                    'string',
                ],

                'sort.*' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.partners.store' => [
                'city_id' => [
                    'required',

                    'integer',

                    Rule::exists('cities', 'id')
                ],

                'code' => [
                    'required',

                    'integer'
                ],

                'address' => [
                    'required',

                    'string'
                ],

                'address_additional' => [
                    'nullable',

                    'string'
                ],

                'name' => [
                    'nullable',

                    'string',
                ],

                'photo' => [
                    'nullable',

                    'url',
                ],

                'weight_price' => [
                    'required',

                    'numeric'
                ],

                'warehouse_price' => [
                    'required',

                    'numeric'
                ],

                'discount_price' => [
                    'required',

                    'numeric'
                ],

                'pickup' => [
                    'required',

                    'numeric'
                ],

                'delivery' => [
                    'required',

                    'numeric'
                ],
            ],

            'dashboard.partners.update' => [
                'city_id' => [
                    'required',

                    'integer',

                    Rule::exists('cities', 'id')
                ],

                'code' => [
                    'required',

                    'integer'
                ],

                'address' => [
                    'required',

                    'string'
                ],

                'address_additional' => [
                    'nullable',

                    'string'
                ],

                'name' => [
                    'required',

                    'string',
                ],

                'weight_price' => [
                    'required',

                    'numeric'
                ],

                'warehouse_price' => [
                    'required',

                    'numeric'
                ],

                'discount_price' => [
                    'required',

                    'numeric'
                ],

                'pickup' => [
                    'required',

                    'numeric'
                ],

                'delivery' => [
                    'required',

                    'numeric'
                ],

                'photo' => [
                    'nullable',

                    'url',
                ],
            ],
        ];


        return $rules[$this->route()->getName()];
    }
}

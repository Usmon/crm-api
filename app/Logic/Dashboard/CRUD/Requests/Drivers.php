<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Drivers extends FormRequest
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
            'dashboard.drivers.index' => [
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

                'creator' => [
                    'nullable',

                    'string',
                ],

                'user_id' => [
                    'nullable',

                    'integer',
                ],

                'region' => [
                    'nullable',

                    'string',
                ],

                'city' => [
                    'nullable',

                    'string',
                ],

                'address' => [
                    'nullable',

                    'string',
                ],

                'region_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('regions', 'id'),
                ],

                'city_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('cities', 'id'),
                ],

                'address_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('addresses', 'id'),
                ],

                'car_model' => [
                    'nullable',

                    'string',
                ],

                'car_number' => [
                    'nullable',

                    'string',
                ],

                'license' => [
                    'nullable',

                    'string'
                ],

                'user' => [
                    'nullable',

                    'string',
                ],

                'sort.*' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.drivers.store' => [
                'user_id' => [
                    'required',

                    'integer',
                ],

                'region_id' => [
                    'required',

                    'integer',

                    Rule::exists('regions', 'id'),
                ],

                'city_id' => [
                    'required',

                    'integer',

                    Rule::exists('cities', 'id'),
                ],

                'address_id' => [
                    'required',

                    'integer',

                    Rule::exists('addresses', 'id'),
                ],

                'car_model' => [
                    'required',

                    'string',
                ],

                'car_number' => [
                    'required',

                    'string',
                ],

                'license' => [
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

            'dashboard.drivers.update' => [
                'user_id' => [
                    'required',

                    'integer',
                ],

                'region_id' => [
                    'required',

                    'regions',

                    Rule::exists('regions', 'id'),
                ],

                'city_id' => [
                    'required',

                    'integer',

                    Rule::exists('cities', 'id'),
                ],

                'address_id' => [
                    'required',

                    'integer',

                    Rule::exists('addresses', 'id'),
                ],

                'car_model' => [
                    'required',

                    'string',
                ],

                'car_number' => [
                    'required',

                    'string',
                ],

                'license' => [
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

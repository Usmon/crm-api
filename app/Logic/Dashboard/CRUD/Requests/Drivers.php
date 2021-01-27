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

                'name' => [
                    'nullable',

                    'string',
                ],

                'email' => [
                    'nullable',

                    'string',
                ],

                'phone' => [
                    'nullable',

                    'string',
                ],

                'region' => [
                    'nullable',

                    'string',
                ],

                'city' => [
                    'nullable',

                    'string',
                ],

                'zip_or_post_code' => [
                    'nullable',

                    'string',
                ],

                'address' => [
                    'nullable',

                    'string',
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

                'sort.*' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.drivers.store' => [
                'name' => [
                    'required',

                    'string',
                ],

                'phone' => [
                    'required',

                    'string',
                ],

                'email' => [
                    'required',

                    'email',

                    Rule::unique('drivers','email'),
                ],

                'region' => [
                    'required',

                    'string',
                ],

                'city' => [
                    'required',

                    'string',
                ],

                'zip_or_post_code' => [
                    'required',

                    'string',
                ],

                'address' => [
                    'required',

                    'string',
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
                'name' => [
                    'required',

                    'string',
                ],

                'phone' => [
                    'required',

                    'string',
                ],

                'email' => [
                    'required',

                    'email',

                    Rule::unique('drivers','email'),
                ],

                'region' => [
                    'required',

                    'string',
                ],

                'city' => [
                    'required',

                    'string',
                ],

                'zip_or_post_code' => [
                    'required',

                    'string',
                ],

                'address' => [
                    'required',

                    'string',
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

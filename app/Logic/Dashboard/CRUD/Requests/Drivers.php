<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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

                    Rule::exists('users', 'id'),
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

                    Rule::exists('users', 'id'),
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
            ],

            'dashboard.drivers.update' => [
                'user_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
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
            ],

            'dashboard.drivers.phone.check' => [
                'phone' => [
                    'required',

                    'string',

                    Rule::exists('phones', 'phone')
                ],
            ],

            'dashboard.drivers.phone.search' => [
                'phone' => [
                    'required',

                    'string'
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

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
            'dashboard.drivers.driver.index' => [
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

            'dashboard.drivers.driver.store' => [
                'driver' => [
                    'required',

                    'array'
                ],

                'driver.full_name' => [
                    'required',

                    'string',

                    'max:128',
                ],

                'driver.email' => [
                    'required',

                    'string',

                    Rule::unique('users', 'email')
                ],

                'driver.phones' => [
                    'required',

                    'array'
                ],

                'driver.phones.*' => [
                    'required',

                    'string',

                    Rule::unique('phones', 'phone')
                ],

                'car' => [
                    'required',

                    'array'
                ],

                'car.partner_id' => [
                    'required',

                    'integer',

                    Rule::exists('partners', 'id')
                ],

                'car.car_model' => [
                    'required',

                    'string',
                ],

                'car.car_number' => [
                    'required',

                    'string',

                    Rule::unique('drivers', 'car_number')
                ],

                'car.license' => [
                    'required',

                    'string',

                    Rule::unique('drivers', 'license')
                ],
            ],

            'dashboard.drivers.driver.update' => [
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

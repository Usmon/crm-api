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

                    //Rule::unique('phones', 'phone')
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

                    //Rule::unique('drivers', 'car_number')
                ],

                'car.license' => [
                    'required',

                    'string',

                    //Rule::unique('drivers', 'license')
                ],
            ],

            'dashboard.drivers.driver.update' => [
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

                    Rule::unique('users', 'email')->ignore($this->route('driver')->user_id ?? 0)
                ],

                'driver.phones' => [
                    'required',

                    'array'
                ],

                'driver.phones.*' => [
                    'required',

                    'string',

                    //Rule::unique('phones', 'phone')->ignore($this->route('driver')->user_id ?? 0, 'user_id')
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

                    //Rule::unique('drivers', 'car_number')->ignore($this->route('driver')->id ?? 0)
                ],

                'car.license' => [
                    'required',

                    'string',

                    //Rule::unique('drivers', 'license')->ignore($this->route('driver')->id ?? 0)
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

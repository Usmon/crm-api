<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Deliveries extends FormRequest
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
            'dashboard.deliveries.index' => [
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

                'customer_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('customers','id'),
                ],

                'driver_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id'),
                ],

                'status' => [
                    'nullable',

                    'string'
                ],

                'sort.*' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.deliveries.store' => [
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('customers', 'id'),
                ],

                'driver_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'status' => [
                    'required',

                    'string',

                    'in:pending,delivering,delivered'
                ],
            ],

            'dashboard.deliveries.update' => [
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('customers', 'id'),
                ],

                'driver_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'status' => [
                    'required',

                    'string',

                    'in:pending,delivering,delivered'
                ],
            ],

        ];

        return $rules[$this->route()->getName()];
    }
}

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
            ],

            'dashboard.deliveries.store' => [
                'order_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders', 'id'),
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
                'order_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders', 'id'),
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

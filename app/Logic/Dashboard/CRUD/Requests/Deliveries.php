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
            'dashboard.deliveries.delivery.index' => [
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

                'status_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('statuses', 'id')
                ],

                'customer' => [
                    'nullable',

                    'string',
                ],

                'driver' => [
                    'nullable',

                    'string',
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

            'dashboard.deliveries.delivery.store' => [
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

                'status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id'),
                ],
            ],

            'dashboard.deliveries.delivery.update' => [
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

                'status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id'),
                ],
            ],

        ];

        return $rules[$this->route()->getName()];
    }
}

<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Pickups extends FormRequest
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
            'dashboard.pickups.index' => [
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

                'pickup_datetime_start' => [
                    'nullable',

                    'array',
                ],

                'pickup_datetime_start.from' => [
                    'nullable',

                    'date',

                    'before:now',
                ],

                'pickup_datetime_start.to' => [
                    'nullable',

                    'date',

                    'after:pickup_datetime_start.from',
                ],

                'pickup_datetime_end' => [
                    'nullable',

                    'array',
                ],

                'pickup_datetime_end.from' => [
                    'nullable',

                    'date',

                    'before:now',
                ],

                'pickup_datetime_end.to' => [
                    'nullable',

                    'date',

                    'after:pickup_datetime_start.from',
                ],

                'status' => [
                    'nullable',

                    'string',
                ],

                'customer_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('customers', 'id'),
                ],

                'driver_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('drivers', 'id'),
                ],

                'creator_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'customer' => [
                    'nullable',

                    'string',
                ],

                'driver' => [
                    'nullable',

                    'string',
                ],

                'creator' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.pickups.store' => [
                'pickup_datetime_start' => [
                    'required',

                    'date',
                ],

                'pickup_datetime_end' => [
                    'required',

                    'date',
                ],

                'status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id'),
                ],

                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('customers', 'id'),
                ],

                'driver_id' => [
                    'required',

                    'integer',

                    Rule::exists('drivers', 'id'),
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

            'dashboard.pickups.update' => [
                'pickup_datetime_start' => [
                    'required',

                    'date',
                ],

                'pickup_datetime_end' => [
                    'required',

                    'date',
                ],

                'status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id'),
                ],

                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('customers', 'id'),
                ],

                'driver_id' => [
                    'required',

                    'integer',

                    Rule::exists('drivers', 'id'),
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

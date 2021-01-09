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

                'note' => [
                    'nullable',

                    'string',
                ],

                'bring_address' => [
                    'nullable',

                    'array',
                ],

                'bring_datetime_start' => [
                    'nullable',

                    'array',
                ],

                'bring_datetime_end' => [
                    'nullable',

                    'array',
                ],

                'staff_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id'),
                ],

                'driver_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id'),
                ],

                'customer_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id'),
                ],

                'staff' => [
                    'nullable',

                    'string',
                ],

                'driver' => [
                    'nullable',

                    'string',
                ],

                'customer' => [
                    'nullable',

                    'string',
                ],

            ],

            'dashboard.pickups.store' => [
                'note' => [
                    'required',

                    'string',

                    'max:255',
                ],
                'bring_address' => [
                    'required',

                    'string',
                ],
                'bring_datetime_start' => [
                    'required',

                    'date',
                ],
                'bring_datetime_end' => [
                    'required',

                    'date',
                ],
                'staff_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],
                'driver_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
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
                'note' => [
                    'required',

                    'string',

                    'max:255',
                ],
                'bring_address' => [
                    'required',

                    'string',
                ],
                'bring_datetime_start' => [
                    'required',

                    'date',
                ],
                'bring_datetime_end' => [
                    'required',

                    'date',
                ],
                'staff_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],
                'driver_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
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

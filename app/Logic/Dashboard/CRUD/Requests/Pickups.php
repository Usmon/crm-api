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

                'pickup_datetime_start' => [
                    'nullable',

                    'array',
                ],

                'pickup_datetime_end' => [
                    'nullable',

                    'array',
                ],

                'status' => [
                    'nullable',

                    'string',
                ],

                'sender_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('senders', 'id'),
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

                'sender' => [
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

                'status' => [
                    'in:pending,on_the_road,at_the_office',
                ],

                'sender_id' => [
                    'required',

                    'integer',

                    Rule::exists('senders', 'id'),
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

                'status' => [
                    'required',

                    'in:pending,on_the_road,at_the_office',
                ],

                'sender_id' => [
                    'required',

                    'integer',

                    Rule::exists('senders', 'id'),
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

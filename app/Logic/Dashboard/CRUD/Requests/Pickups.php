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

                'index' => [
                    'nullable',

                    'string'
                ],

                'status_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('statuses', 'id'),
                ],
            ],

            'dashboard.pickups.store' => [
                'type' => [
                    'required',
                ],

                'type.index' => [
                    'required',

                    'string',
                ],

                'type.date' => [
                    'required',

                    'array',
                ],

                'type.date.from' => [
                    'required',

                    'date',
                ],

                'type.date.to' => [
                    'required',

                    'date',
                ],

                'status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses','id'),
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

                'price' => [
//                    'required',

                    'numeric',

                    'min:0'
                ],

                'boxes' => [
//                    'required',

                    'array',
                ],

                'boxes.*.note' => [
                    'nullable',

                    'string',
                ],

                'boxes.*.products' => [
                    'required',

                    'array',
                ],

                'boxes.*.products.*.name' => [
                    'required',

                    'string',
                ],

                'boxes.*.products.*.quantity' => [
                    'required',

                    'integer',
                ],

                'boxes.*.products.*.price' => [
                    'required',

                    'numeric',
                ],

                'boxes.*.products.*.weight' => [
                    'required',

                    'numeric',
                ],

                'boxes.*.products.*.type_weight' => [
                    'required',

                    'string',

                    'in:lb,kg'
                ],

                'boxes.*.products.*.note' => [
                    'nullable',

                    'string',
                ],

                'boxes.*.products.*.image' => [
                    'nullable',

                    'string',
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

                    Rule::exists('statuses','id'),
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

                'price' => [
//                    'required',

                    'numeric',

                    'min:0',
                ],
            ],

            'dashboard.updatePickupStatus' => [
                'status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id'),
                ],
            ],

            'dashboard.pickup.check-time' => [
                'date' => [
                    'required',

                    'date',
                ],

                'type' => [
                    'required',

                    'string',

                    Rule::in(['pickup', 'fedex'])
                ]
            ]
        ];
        return $rules[$this->route()->getName()];
    }
}

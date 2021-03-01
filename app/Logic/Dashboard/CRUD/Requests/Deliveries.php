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

                    'after:date.from',
                ],

                'recipient_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('recipients','id'),
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

                'recipient' => [
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

                'creator_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'creator' => [
                    'nullable',

                    'string',
                ],

                'sort.*' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.deliveries.delivery.store' => [
                'recipient_id' => [
                    'required',

                    'integer',

                    Rule::exists('recipients', 'id'),
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
                'recipient_id' => [
                    'required',

                    'integer',

                    Rule::exists('recipients', 'id'),
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

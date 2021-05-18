<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Shipments extends FormRequest
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
            'dashboard.shipments.shipment.index' => [
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

                'name' => [
                    'nullable',

                    'string',
                ],

                'status' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.shipments.shipment.store' => [
                'name' => [
                    'required',

                    'string',
                ],
            ],

            'dashboard.shipments.shipment.update' => [
                'status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id'),
                ],

                'name' => [
                    'required',

                    'string',
                ],
            ],

            'dashboard.shipments.attach-boxes' => [
                'id' => [
                    'required',

                    'array',
                ],

                'id.*' => [
                    'required',

                    'integer',

                    Rule::exists('boxes', 'id')->where('shipment_id', null),
                ],
            ],

            'dashboard.shipments.unattach-boxes' => [
                'id' => [
                    'required',

                    'array',
                ],

                'id.*' => [
                    'required',

                    'integer',

                    Rule::exists('boxes', 'id')->whereNot('shipment_id', null),
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

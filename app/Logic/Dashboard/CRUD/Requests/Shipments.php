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

                'boxes' => [
                    'required',

                    'array',
                ],

                'boxes.*' => [
                    'required',

                    'integer',

                    Rule::exists('boxes', 'id'),
                ],
            ],

            'dashboard.shipments.shipment.update' => [
                'name' => [
                    'required',

                    'string',
                ],

                'boxes' => [
                    'required',

                    'array',
                ],

                'boxes.*' => [
                    'required',

                    'integer',

                    Rule::exists('boxes', 'id'),
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

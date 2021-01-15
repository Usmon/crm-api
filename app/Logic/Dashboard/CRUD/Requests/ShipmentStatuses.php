<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class ShipmentStatuses extends FormRequest
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
            'dashboard.shipments.statuses.index' => [
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
            ],

            'dashboard.shipments.statuses.store' => [
                'name' => [
                    'required',

                    'string',

                    'max:255',

                    Rule::unique('shipment_statuses', 'name'),
                ],

                'color' => [
                    'required',

                    'array',
                ],

                'color.bg' => [
                    'required',

                    'string',

                    'max:255',
                ],

                'color.text' => [
                    'required',

                    'string',

                    'max:255',
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

            'dashboard.shipments.statuses.update' => [
                'name' => [
                    'required',

                    'string',

                    'max:255',

                    Rule::unique('shipment_statuses', 'name'),
                ],

                'color' => [
                    'required',

                    'array',
                ],

                'color.bg' => [
                    'required',

                    'string',

                    'max:255',
                ],

                'color.text' => [
                    'required',

                    'string',

                    'max:255',
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

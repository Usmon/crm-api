<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Export extends FormRequest
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
            'dashboard.export.boxes' => [
                'id' => [
                    'required',

                    'array'
                ],

                'id.*' => [
                    'required',

                    'integer'
                ]
            ],

            'dashboard.export.shipment-declaration' => [
                'id' => [
                    'required',

                    'integer',

                    Rule::exists('shipments', 'id')
                ],

                'response_type' => [
                    'nullable',

                    'string',

                    Rule::in(['stream', 'download'])
                ],
            ]
        ];

        return $rules[$this->route()->getName()];
    }
}

<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Cities extends FormRequest
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
            'dashboard.cities.index' => [
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

                'address_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('address','id'),
                ],

                'name' => [
                    'nullable',

                    'string',
                ],

                'sort.*' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.cities.store' => [
                'address_id' => [
                    'required',

                    'integer',
                ],

                'name' => [
                    'required',

                    'string',
                ],
            ],

            'dashboard.cities.update' => [
                'address_id' => [
                    'required',

                    'integer',
                ],

                'name' => [
                    'required',

                    'string',
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

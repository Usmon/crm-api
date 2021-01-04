<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Trackings extends FormRequest
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
            'dashboard.trackings.index' => [
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

                'tracking' => [
                    'nullable',

                    'string',
                ],

                'customer' => [
                    'nullable',

                    'string',
                ],

                'sort.*' => [
                    'nullable',

                    'string',

                    // @todo filtering columns in keys
                ],
            ],

            'dashboard.trackings.store' => [
                'tracking' => [
                    'required',

                    'string',

                    Rule::unique('trackings','tracking'),
                ],

                'customer_id' => [
                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'item' => [
                    'integer',

                    'min:0',
                ],

                'color' => [
                    'string',
                ],

                'QTN' => [
                    'integer',

                    'min:0',
                ],

                'box_id' => [
                    'integer',

                    Rule::exists('boxes','id'),
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

            'dashboard.trackings.update' => [
                'tracking' => [
                    'required',

                    'string',

                    Rule::unique('trackings','tracking'),
                ],

                'customer_id' => [
                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'item' => [
                    'integer',

                    'min:0',
                ],

                'color' => [
                    'string',
                ],

                'QTN' => [
                    'integer',

                    'min:0',
                ],

                'box_id' => [
                    'integer',

                    Rule::exists('boxes','id'),
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

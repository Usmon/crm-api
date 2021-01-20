<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Statuses extends FormRequest
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
            'dashboard.status.statuses.index' => [
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

                'model' => [
                    'nullable',

                    'string',
                ],

                'key' => [
                    'nullable',

                    'string',
                ],

                'value' => [
                    'nullable',

                    'string',
                ],

                'parameters' => [
                    'nullable',

                    'string',
                ],

                'sort.*' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.status.statuses.store' => [
                'model' => [
                    'required',

                    'string',
                ],

                'key' => [
                    'required',

                    'string',
                ],

                'value' => [
                    'required',

                    'string',
                ],

                'parameters' => [
                    'required',
                ],

                'image' => [
                    'string',
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

            'dashboard.status.statuses.update' => [
                'model' => [
                    'required',

                    'string',
                ],

                'key' => [
                    'required',

                    'string',
                ],

                'value' => [
                    'required',

                    'string',
                ],

                'parameters' => [
                    'required',
                ],

                'string' => [
                    'string',
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

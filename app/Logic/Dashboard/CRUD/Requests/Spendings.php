<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Spendings extends FormRequest
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
            'dashboard.spendings.spending.index' => [
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

                'creator_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id'),
                ],

                'amount' => [
                    'nullable',

                    'array',
                ],

                'category_id.*' => [
                    'nullable',

                    'integer',

                    Rule::exists('spending_categories','id'),
                ],

                'sort.*' => [
                    'nullable',

                    'string',

                    // @todo filtering columns in keys
                ],
            ],

            'dashboard.spendings.spending.store' => [
                'amount' => [
                    'required',

                    'numeric',
                ],

                'category_id' => [
                    'required',

                    'integer',

                    Rule::exists('spending_categories', 'id'),
                ],

                'note' => [
                    'required',

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

            'dashboard.spendings.spending.update' => [
                'amount' => [
                    'required',

                    'numeric',
                ],

                'category_id' => [
                    'required',

                    'integer',

                    Rule::exists('spending_categories', 'id'),
                ],

                'note' => [
                    'required',

                    'string'
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

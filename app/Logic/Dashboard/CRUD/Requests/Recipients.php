<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Recipients extends FormRequest
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
            'dashboard.recipients.index' => [
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

                'customer_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id'),
                ],

                'customer' => [
                    'nullable',

                    'string',
                ],

                'sort.*' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.recipients.store' => [
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id')
                ],
            ],

            'dashboard.recipients.update' => [
                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id')
                ],

            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

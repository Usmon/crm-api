<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Customers extends FormRequest
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
            'dashboard.customers.index' => [
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

                'user_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'creator_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'referral_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'passport' => [
                    'nullable',

                    'string',
                ],

                'balance' => [
                    'nullable',

                    'array',
                ],

                'birth_date' => [
                    'nullable',

                    'date',
                ],

                'note' => [
                    'nullable',

                    'string',
                ],

                'phone' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.customers.store' => [
                'user_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'referral_id' => [
                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'passport' => [
                    'required',

                    'string'
                ],

                'balance' => [
                    'integer',

                    'min:0',
                ],

                'birth_date' => [
                    'required',

                    'date',
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

            'dashboard.customers.update' => [
                'user_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'referral_id' => [
                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'passport' => [
                    'required',

                    'string'
                ],

                'balance' => [
                    'integer',

                    'min:0',
                ],

                'birth_date' => [
                    'required',

                    'date',
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

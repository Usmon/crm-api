<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class OrderUsers extends FormRequest
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
            'dashboard.order-users.index' => [
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

                'order_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('orders', 'id'),
                ],
            ],

            'dashboard.order-users.store' => [
                'user_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'order_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders', 'id'),
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

            'dashboard.order-users.update' => [
                'user_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'order_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders', 'id'),
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

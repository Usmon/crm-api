<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class OrderComments extends FormRequest
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
            'dashboard.order-comments.index' => [
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
            ],

            'dashboard.order-comments.store' => [
                'order_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders', 'id'),
                ],

                'owner_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'comment' => [
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

            'dashboard.order-comments.update' => [
                'order_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders', 'id'),
                ],

                'owner_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'comment' => [
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
        ];

        return $rules[$this->route()->getName()];
    }
}

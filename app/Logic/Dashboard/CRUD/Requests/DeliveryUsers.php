<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class DeliveryUsers extends FormRequest
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
            'dashboard.delivery-users.index' => [
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

                'delivery_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('deliveries', 'id'),
                ],
            ],

            'dashboard.delivery-users.store' => [
                'user_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'delivery_id' => [
                    'required',

                    'integer',

                    Rule::exists('deliveries', 'id'),
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

            'dashboard.delivery-users.update' => [
                'user_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'delivery_id' => [
                    'required',

                    'integer',

                    Rule::exists('deliveries', 'id'),
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

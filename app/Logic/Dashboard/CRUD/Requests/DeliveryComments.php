<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class DeliveryComments extends FormRequest
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
            'dashboard.delivery-comments.index' => [
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

                'delivery_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('deliveries', 'id'),
                ],

                'comment' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.delivery-comments.store' => [
                'delivery_id' => [
                    'required',

                    'integer',

                    Rule::exists('deliveries', 'id'),
                ],

                'comment' => [
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

            'dashboard.delivery-comments.update' => [
                'delivery_id' => [
                    'required',

                    'integer',

                    Rule::exists('deliveries', 'id'),
                ],

                'comment' => [
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

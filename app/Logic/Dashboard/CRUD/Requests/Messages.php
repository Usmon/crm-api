<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Messages extends FormRequest
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
            'dashboard.messages.index' => [
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

            'dashboard.messages.store' => [
                'sender_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id')
                ],

                'receiver_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id')
                ],

                'body' => [
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

            'dashboard.messages.update' => [
                'sender_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id')
                ],

                'receiver_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id')
                ],

                'body' => [
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

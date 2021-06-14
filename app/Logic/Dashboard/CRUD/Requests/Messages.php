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

                'message' => [
                    'nullable',

                    'string'
                ],

                'sender_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id'),
                ],

                'receiver_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users','id')
                ],

                'sender' => [
                    'nullable',

                    'string',
                ],

                'receiver' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.messages.store' => [
                'phones' => [
                    'required',

                    'array',
                ],

                'phones.*' => [
                    'required',

                    'string',

                    Rule::exists('phones', 'phone')
                ],

                'body' => [
                    'required',

                    'string'
                ],
            ],

            'dashboard.messages.update' => [
                'receiver_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id')
                ],

                'body' => [
                    'required',

                    'string'
                ],
            ],

//            'dashboard.getMessages.user' => [
//                'user_id' => [
//                    'required',
//
//                    'integer',
//
//                    Rule::exists('users', 'id'),
//                ],
//            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

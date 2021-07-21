<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Users extends FormRequest
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
            'dashboard.users.index' => [
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

                'role' => [
                    'nullable',

                    'integer',

                    Rule::exists('roles', 'id'),
                ],

                'only_corporate' => [
                    'nullable',

                    'bool'
                ]
            ],

            'dashboard.users.store' => [
                'login' => [
                    'required',

                    'string',

                    'max:255',

                    Rule::unique('users', 'login'),
                ],

                'email' => [
                    'required',

                    'email',

                    'string',

                    'max:255',

                    Rule::unique('users', 'email'),
                ],

                'password' => [
                    'required',

                    'string',

                    'min:8',

                    'max:255',

                    'confirmed',
                ],

                'profile' => [
                    'nullable',

                    'array',
                ],

                'profile.first_name' => [
                    'nullable',

                    'string',

                    'max:255',
                ],

                'profile.middle_name' => [
                    'nullable',

                    'string',

                    'max:255',
                ],

                'profile.last_name' => [
                    'nullable',

                    'string',

                    'max:255',
                ],

                'roles' => [
                    'required',

                    'array',
                ],

                'roles.*' => [
                    'required',

                    'integer',

                    Rule::exists('roles', 'id'),
                ],

                'partner_id' => [
                    'required',

                    'integer',

                    Rule::exists('partners', 'id')
                ]
            ],

            'dashboard.users.update' => [
                'login' => [
                    'required',

                    'string',

                    'max:255',

                    Rule::unique('users', 'login')->ignore($this->route('user')),
                ],

                'email' => [
                    'required',

                    'email',

                    'string',

                    'max:255',

                    Rule::unique('users', 'email')->ignore($this->route('user')),
                ],

                'password' => [
                    'nullable',

                    'string',

                    'min:8',

                    'max:255',

                    'confirmed',
                ],

                'profile' => [
                    ' nullable',

                    'array',
                ],

                'profile.first_name' => [
                    'nullable',

                    'string',

                    'max:255',
                ],

                'profile.middle_name' => [
                    'nullable',

                    'string',

                    'max:255',
                ],

                'profile.last_name' => [
                    'nullable',

                    'string',

                    'max:255',
                ],

                'roles' => [
                    'required',

                    'array',
                ],

                'roles.*' => [
                    'required',

                    'integer',

                    Rule::exists('roles', 'id'),
                ],

                'partner_id' => [
                    'required',

                    'integer',

                    Rule::exists('partners', 'id')
                ]
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

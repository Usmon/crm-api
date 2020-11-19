<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class Roles extends FormRequest
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
            'dashboard.roles.index' => [
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

            'dashboard.roles.store' => [
                'name' => [
                    'required',

                    'string',

                    'max:255',

                ],

                'slug' => [
                    'required',

                    'string',

                    'max:255',

                ],

                'description' => [
                    'required',

                    'string',

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

            ],

            'dashboard.roles.update' => [
                'name' => [
                    'required',

                    'string',

                    'max:255',

                ],

                'slug' => [
                    'required',

                    'string',

                    'max:255',

                ],

                'description' => [
                    'required',

                    'string',

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
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

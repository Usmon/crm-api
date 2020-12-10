<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Tasks extends FormRequest
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
            'dashboard.tasks.index' => [
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

            'dashboard.tasks.store' => [
                'project_id' => [
                    'required',

                    'integer',

                    Rule::exists('projects', 'id'),
                ],

                'title' => [
                    'required',

                    'string',
                ],

                'note' => [
                    'required',

                    'string',
                ],

                'in_may_day' => [
                    'integer',
                ],

                'is_completed' => [
                    'integer',
                ],

                'is_important' => [
                    'integer'
                ],

                'remind_me_at' => [
                    'required',

                    'date_format:Y-m-d H:i:s'
                ],

                'due_date' => [
                    'required',

                    'date'
                ],

                'next_repeat' => [
                    'required',

                    'date_format:Y-m-d H:i:s'
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

            'dashboard.tasks.update' => [
                'project_id' => [
                    'required',

                    'integer',

                    Rule::exists('projects', 'id'),
                ],

                'title' => [
                    'required',

                    'string',
                ],

                'note' => [
                    'required',

                    'string',
                ],

                'in_may_day' => [
                    'integer',
                ],

                'is_completed' => [
                    'integer',
                ],

                'is_important' => [
                    'integer'
                ],

                'remind_me_at' => [
                    'required',

                    'date_format:Y-m-d H:i:s',
                ],

                'due_date' => [
                    'required',

                    'date'
                ],

                'next_repeat' => [
                    'required',

                    'date_format:Y-m-d H:i:s'
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

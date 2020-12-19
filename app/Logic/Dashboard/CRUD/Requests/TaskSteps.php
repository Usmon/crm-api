<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class TaskSteps extends FormRequest
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
            'dashboard.task-steps.index' => [
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

                'task_id' => [
                    'nullable',

                     'integer',

                    Rule::exists('tasks','id'),
                ],

                'step' => [
                    'nullable',

                    'string',
                ]
            ],

            'dashboard.task-steps.store' => [
                'task_id' => [
                    'required',

                    'integer',

                    Rule::exists('tasks', 'id'),
                ],

                'step' => [
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

            'dashboard.task-steps.update' => [
                'task_id' => [
                    'required',

                    'integer',

                    Rule::exists('tasks', 'id'),
                ],

                'step' => [
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

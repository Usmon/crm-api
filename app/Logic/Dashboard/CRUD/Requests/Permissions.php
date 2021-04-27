<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Permissions extends FormRequest
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
            'dashboard.permissions.index' => [
                'search' => [
                    'nullable',

                    'string',

                    'max:255',
                ],
            ],

            'dashboard.permissions.store' => [
                'name' => [
                    'required',

                    'string',

                    'max:255',

                    Rule::unique('permissions', 'name'),
                ],
            ],

            'dashboard.permissions.update' => [
                'name' => [
                    'required',

                    'string',

                    'max:255',

                    Rule::unique('permissions', 'name')->ignore($this->route('permissions')),
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

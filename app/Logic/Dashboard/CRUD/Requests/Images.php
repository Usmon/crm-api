<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Images extends FormRequest
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
            'dashboard.images.store' => [
                'folder' => [
                    'required',

                    'string',
                ],

                'image' => [
                    'required',

                    'image',

                    'mimes:jpeg,png,jpg,svg',
                ],
            ],

            'dashboard.images.update' => [
                'folder' => [
                    'required',

                    'string',
                ],

                'image' => [
                    'required',

                    'image',

                    'mimes:jpeg,png,jpg,svg'
                ],

            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

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

            'dashboard.images.delete' => [
                'image_url' => [
                    'required',

                    'url'
                ]
            ],

            'dashboard.images.delete.multiple' => [
                'image_url' => [
                    'required',

                    'array'
                ],

                'image_url.*' => [
                    'required',

                    'url'
                ]
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

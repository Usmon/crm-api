<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class Export extends FormRequest
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
            'dashboard.export.boxes' => [
                'id' => [
                    'required',

                    'array'
                ],

                'id.*' => [
                    'required',

                    'integer'
                ]
            ]
        ];

        return $rules[$this->route()->getName()];
    }
}

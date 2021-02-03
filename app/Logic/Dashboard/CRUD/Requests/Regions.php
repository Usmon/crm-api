<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Regions extends FormRequest
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
           'dashboard.regions.index' => [
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

                'name' => [
                    'nullable',

                    'string',
                ],

                'zip_code' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.regions.store' => [

                'address_id' => [

                    'required',

                    'integer',

                    Rule::exists('addresses','id')
                ],

                'name' => [

                    'required',

                    'string',
                ],

                'zip_code' => [
                    'required',

                    'string',
                ],

            ],

            'dashboard.regions.update' => [

                'address_id' => [

                    'required',

                    'integer',

                    Rule::exists('addresses','id')
                ],

                'name' => [

                    'required',

                    'string',
                ],

                'zip_code' => [
                    'required',

                    'string',
                ],

            ],

        ];

        return $rules[$this->route()->getName()];
    }
}

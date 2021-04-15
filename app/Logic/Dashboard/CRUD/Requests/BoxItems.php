<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class BoxItems extends FormRequest
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
            'dashboard.boxes.items.index' => [
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

                    'after:date.from'
                ],

                'quantity' => [
                    'nullable',

                    'integer',
                ],

                'weight' => [
                    'nullable',

                    'numeric',

                    'min:0'
                ],

                'price' => [
                    'nullable',

                    'numeric',

                    'min:0'
                ]
            ],

            'dashboard.boxes.items.store' => [
                'box_id' => [
                    'required',

                    'integer',

                    Rule::exists('boxes','id'),
                ],

                'name' => [
                    'required',

                    'string',
                ],

                'quantity' => [
                    'required',

                    'integer',
                ],

                'price' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'weight' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'made_in' => [
                    'required',

                    'string',
                ],

                'note' => [
                    'required',

                    'string',

                    'max:255'
                ],

                'is_additional' => [
                    'required',

                    'integer',

                    'max:255'
                ],
            ],

            'dashboard.boxes.items.update' => [
                'box_id' => [
                    'required',

                    'integer',

                    Rule::exists('boxes','id'),
                ],

                'name' => [
                    'required',

                    'string',
                ],

                'quantity' => [
                    'required',

                    'integer',
                ],

                'price' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'weight' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'made_in' => [
                    'required',

                    'string',
                ],

                'note' => [
                    'required',

                    'string',

                    'max:255'
                ],

                'is_additional' => [
                    'required',

                    'integer',

                    'max:255'
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

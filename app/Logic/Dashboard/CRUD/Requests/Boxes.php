<?php

namespace App\Logic\Dashboard\CRUD\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

final class Boxes extends FormRequest
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
            'dashboard.boxes.box.index' => [
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

                'pickup_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('pickups','id'),
                ],

                'status_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('statuses','id'),
                ],

                'weight' => [
                    'nullable',

                    'array',
                ],

                'weight.from' => [
                    'nullable',

                    'numeric',
                ],

                'weight.to' => [
                    'nullable',

                    'numeric',
                ],

                'additional_weight' => [
                    'nullable',

                    'array',
                ],

                'additional_weight.from' => [
                    'nullable',

                    'numeric',
                ],

                'additional_weight.to' => [
                    'nullable',

                    'numeric',
                ],

                'status' => [
                    'nullable',

                    'string',
                ],
            ],

            'dashboard.boxes.box.store' => [
                'pickup_id' => [
                    'required',

                    'integer',

                    Rule::exists('pickups','id'),
                ],

                'status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id'),
                ],

                'delivery_id' => [
                    'integer',

                    Rule::exists('deliveries', 'id'),
                ],

                'weight' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'additional_weight' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'box_image' => [
                    'string',

                    'max:255'
                ],
            ],

            'dashboard.boxes.box.update' => [
                'pickup_id' => [
                    'required',

                    'integer',

                    Rule::exists('pickups','id'),
                ],

                'status_id' => [
                    'required',

                    'integer',

                    Rule::exists('statuses', 'id'),
                ],

                'delivery_id' => [
                    'integer',

                    Rule::exists('deliveries', 'id'),
                ],

                'weight' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'additional_weight' => [
                    'required',

                    'numeric',

                    'min:0'
                ],

                'box_image' => [
                    'string',

                    'max:255'
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

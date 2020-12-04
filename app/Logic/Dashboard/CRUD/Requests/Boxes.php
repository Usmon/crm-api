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
            'dashboard.boxes.index' => [
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

                'status' => [
                    'nullable',

                    'string',

                    'max:255',
                ],

                'weight' => [
                    'nullable',

                    'float',
                ],

                'additional_weight' => [
                    'nullable',

                    'float',
                ],
            ],

            'dashboard.boxes.store' => [
                'order_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders','id'),
                ],

                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'sender_id' => [
                    'required',

                    'integer',

                    Rule::exists('senders', 'id'),
                ],

                'recipient_id' => [
                    'required',

                    'integer',

                    Rule::exists('recipient', 'id'),
                ],

                'weight' => [
                    'required',

                    'float',
                ],

                'additional_weight' => [
                    'required',

                    'float',
                ],

                'status' => [
                    'required',

                    'in:pending,waiting',

                    'string',
                ],

                'box_image' => [
                    'required',

                    'string',

                    'max:255'
                ],
            ],

            'dashboard.boxes.update' => [
                'order_id' => [
                    'required',

                    'integer',

                    Rule::exists('orders','id'),
                ],

                'customer_id' => [
                    'required',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'sender_id' => [
                    'required',

                    'integer',

                    Rule::exists('senders', 'id'),
                ],

                'recipient_id' => [
                    'required',

                    'integer',

                    Rule::exists('recipient', 'id'),
                ],

                'weight' => [
                    'required',

                    'float',
                ],

                'additional_weight' => [
                    'required',

                    'float',
                ],

                'status' => [
                    'required',

                    'in:pending,waiting',

                    'string',
                ],

                'box_image' => [
                    'required',

                    'string',

                    'max:255'
                ],
            ],
        ];

        return $rules[$this->route()->getName()];
    }
}

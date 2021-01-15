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

                'order_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('orders','id'),
                ],

                'customer_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('users', 'id'),
                ],

                'sender_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('senders', 'id'),
                ],

                'recipient_id' => [
                    'nullable',

                    'integer',

                    Rule::exists('recipients', 'id'),
                ],

                'weight' => [
                    'nullable',

                    'numeric',

                    'min:0'
                ],

                'additional_weight' => [
                    'nullable',

                    'numeric',

                    'min:0'
                ],

                'order' => [
                    'nullable',

                    'string',
                ],

                'customer' => [
                    'nullable',

                    'string',
                ],

                'sender' => [
                    'nullable',

                    'string',
                ],

                'recipient' => [
                    'nullable',

                    'string',
                ],

                'status' => [
                    'nullable',

                    'string',

                    'max:255',
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

                    Rule::exists('recipients', 'id'),
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

                    Rule::exists('recipients', 'id'),
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

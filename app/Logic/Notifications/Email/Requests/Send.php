<?php


namespace App\Logic\Notifications\Email\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Addresses
 * @package App\Logic\Dashboard\Email\Requests
 */
final class Send extends FormRequest
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
            'email.send' => [
                'emails' => [
                    'array',

                    'required'
                ],

                'emails.*' => [
                    'email',
                ],

                'subject' => [
                    'required',

                    'string',

                    'max:255'
                ],

                'body' => [
                    'required',

                    'string'
                ]
            ]
        ];

        return $rules[$this->route()->getName()];
    }
}

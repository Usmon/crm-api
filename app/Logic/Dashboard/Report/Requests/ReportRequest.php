<?php

namespace App\Logic\Dashboard\Report\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ReportRequest extends FormRequest
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
            'dashboard.reports.user-profile' => [
                'date.from' => [
                    'required',

                    'date'
                ],
                'date.to' => [
                    'required',

                    'date',

                    'after:date.from'
                ],
            ]
        ];

        return $rules[$this->route()->getName()];
    }
}

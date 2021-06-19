<?php


namespace App\Logic\Dashboard\Report\Services;


use Illuminate\Http\Request;

class ReportService
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function getUserCredentials(Request $request): array
    {
        return [
            'date' => [
                $request->json('date.from') ?? $request->get('date.from'),

                $request->json('date.to') ?? $request->get('date.to'),
            ],

            'user_id' => auth()->user()->id
        ];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getOnlyFilters(Request $request): array
    {
        return $request->only('date');
    }
}

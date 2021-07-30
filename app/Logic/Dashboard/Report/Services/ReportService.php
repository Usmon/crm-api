<?php


namespace App\Logic\Dashboard\Report\Services;


use Carbon\Carbon;
use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
                $request->json('date.from') ?? $request->get('date')['from'],

                $request->json('date.to') ?? $request->get('date')['to'],
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

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getPickupCalendarFilter(Request $request): array
    {
        return [
            $request->json('date.from') ?? $request->get('date')['from'],

            $request->json('date.to') ?? $request->get('date')['to']
        ];
    }

    public function getPickupCalendarData(Collection $pickups)
    {
        return $pickups->transform(function(Pickup $pickup) {
            return [
                'pickup_id' => $pickup->id,

                'group' => Carbon::parse($pickup->type['date']['from'])->format('Y-m-d'),

                'date' => [
                    'from' => $pickup->type['date']['from'],

                    'to' => $pickup->type['date']['to'],
                ],

                'customer' => [
                    'id' => $pickup->sender_id,

                    'full_name' => $pickup->sender->customer->user->full_name
                ],

                'driver' => $pickup->driver->user->short_info,

                'status' => $pickup->status->for_color
            ];
        })->groupBy('group')->reverse();
    }
}

<?php


namespace App\Logic\Dashboard\Report\Repositories;

use App\Models\Order;

use App\Models\Pickup;

use App\Models\Delivery;

use App\Models\Shipment;

use Illuminate\Support\Facades\DB;

/**
 * Class ReportRepository
 *
 * @package App\Logic\Dashboard\Report\Repositories
 */
class ReportRepository
{
    /**
     * @param array $credentials
     *
     * @return array
     */
    public function corporateUserReport(array $credentials): array
    {
        $orders = Order::filter(['date' => $credentials['date'], 'staff_id' => $credentials['user_id']])
                        ->select(DB::raw('DATE(`created_at`) as `date`, COUNT(`id`) as `count`'))
                        ->groupBy(DB::raw('DATE(`created_at`)'))
                        ->get();

        $deliveries = Delivery::filter(['date' => $credentials['date'], 'creator_id' => $credentials['user_id']])
                               ->select(DB::raw('DATE(`created_at`) as `date`, COUNT(`id`) as `count`'))
                               ->groupBy(DB::raw('DATE(`created_at`)'))
                               ->get();

        $shipments = Shipment::filter(['date' => $credentials['date'], 'creator_id' => $credentials['user_id']])
                                ->select(DB::raw('DATE(`created_at`) as `date`, COUNT(`id`) as `count`'))
                                ->groupBy(DB::raw('DATE(`created_at`)'))
                                ->get();

        $pickups = Pickup::filter(['date' => $credentials['date'], 'creator_id' => $credentials['user_id']])
                            ->select(DB::raw('DATE(`created_at`) as `date`, COUNT(`id`) as `count`'))
                            ->groupBy(DB::raw('DATE(`created_at`)'))
                            ->get();

        return [
            'orders' => $orders,

            'deliveries' => $deliveries,

            'shipments' => $shipments,

            'pickups' => $pickups
        ];
    }
}

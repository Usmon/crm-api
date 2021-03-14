<?php

namespace Database\Factories;

use App\Models\Box;

use App\Models\Status;

use App\Logic\Dashboard\CRUD\Services\Statuses as StatusService;

use App\Models\Order;

use App\Models\OrderHistory;

use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

final class OrderHistoryFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = OrderHistory::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $orders = Order::all(['id']);

        $users = User::all(['id']);

        $models = collect([Box::class, Order::class]);

        $status = Status::where('model', StatusService::ORDER)->get(['id']);

        return [
            'creator_id' => $users->random(),

            'model_id' => $orders->random(),

            'status_id' => $status->random(),

            'model' => $models->random(),

            'seq' => rand(1, 15)
        ];
    }
}

<?php

namespace App\Providers;

use App\Models\DeliveryComment;
use App\Models\Feedback;

use App\Models\Order;

use App\Models\Project;

use App\Models\Recipient;

use App\Models\Sender;

use App\Models\Shipment;

use App\Models\FedexOrder;

use App\Models\Spending;

use App\Models\SpendingCategory;

use App\Models\Task;

use App\Models\TaskFile;

use App\Models\TaskUser;

use App\Models\TaskStep;

use App\Models\User;

use App\Models\Role;

use App\Models\Token;

use App\Models\Pickup;

use App\Models\Delivery;

use App\Models\Box;

use App\Models\Permission;

use App\Models\WarehouseItem;

use App\Observers\DeliveryCommentObserver;
use App\Observers\FeedbackObserver;

use App\Observers\OrderObserver;

use App\Observers\ProjectObserver;

use App\Observers\RecipientObserver;

use App\Observers\SenderObserver;

use App\Observers\ShipmentObserver;

use App\Observers\SpendingCategoryObserver;

use App\Observers\SpendingObserver;

use App\Observers\TaskFileObserver;
use App\Observers\TaskObserver;

use App\Observers\TaskUserObserver;

use App\Observers\TaskStepObserver;

use App\Observers\UserObserver;

use App\Observers\RoleObserver;

use App\Observers\PickupObserver;

use App\Observers\DeliveryObserver;

use App\Observers\BoxObserver;

use App\Observers\TokenObserver;

use App\Observers\FedexOrderObserver;

use App\Observers\PermissionObserver;

use App\Observers\WarehouseItemObserver;

use Illuminate\Support\ServiceProvider;

final class ObserverServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);

        Role::observe(RoleObserver::class);

        Pickup::observe(PickupObserver::class);

        Delivery::observe(DeliveryObserver::class);

        Token::observe(TokenObserver::class);

        FedexOrder::observe(FedexOrderObserver::class);

        Permission::observe(PermissionObserver::class);

        Shipment::observe(ShipmentObserver::class);

        Order::observe(OrderObserver::class);

        Recipient::observe(RecipientObserver::class);

        Sender::observe(SenderObserver::class);

        WarehouseItem::observe(WarehouseItemObserver::class);

        Box::observe(BoxObserver::class);

        Feedback::observe(FeedbackObserver::class);

        SpendingCategory::observe(SpendingCategoryObserver::class);

        Spending::observe(SpendingObserver::class);

        Project::observe(ProjectObserver::class);

        Task::observe(TaskObserver::class);

        TaskFile::observe(TaskFileObserver::class);

        TaskUser::observe(TaskUserObserver::class);

        TaskStep::observe(TaskStepObserver::class);

        DeliveryComment::observe(DeliveryCommentObserver::class);
    }
}

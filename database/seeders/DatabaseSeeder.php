<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);

        $this->call(RoleSeeder::class);

        $this->call(CountrySeeder::class);

        $this->call(PartnerSeeder::class);

        $this->call(UserSeeder::class);

        $this->call(StatusSeeder::class);

        $this->call(AddressSeeder::class);

        $this->call(DriverSeeder::class);

        $this->call(CustomerSeeder::class);

        $this->call(ShipmentStatusSeeder::class);

        $this->call(ShipmentSeeder::class);

        $this->call(FedexOrderSeeder::class);

        $this->call(SenderSeeder::class);

        $this->call(PickupSeeder::class);

        $this->call(RecipientSeeder::class);

        $this->call(PaymentTypeSeeder::class);

        $this->call(DeliverySeeder::class);

        $this->call(OrderSeeder::class);

        $this->call(SenderSeeder::class);

        $this->call(RecipientSeeder::class);

        $this->call(WarehouseItemSeeder::class);

        $this->call(BoxSeeder::class);

        $this->call(BoxItemSeeder::class);

        $this->call(MessageSeeder::class);

        $this->call(FeedbackSeeder::class);

        $this->call(SpendingCategorySeeder::class);

        $this->call(SpendingSeeder::class);

        $this->call(ProjectSeeder::class);

        $this->call(TaskSeeder::class);

        $this->call(OrderCommentSeeder::class);

        $this->call(TaskFileSeeder::class);

        $this->call(TaskUserSeeder::class);

        $this->call(TaskStepSeeder::class);

        $this->call(ShipmentCommentSeeder::class);

        $this->call(DeliveryCommentSeeder::class);

        $this->call(FedexOrderItemSeeder::class);

        $this->call(ShipmentUserSeeder::class);

        $this->call(OrderUserSeeder::class);

        $this->call(DeliveryUserSeeder::class);

        $this->call(TrackingSeeder::class);

        $this->call(PhoneSeeder::class);

        $this->call(ProductSeeder::class);

        $this->call(OrderHistorySeeder::class);
    }
}

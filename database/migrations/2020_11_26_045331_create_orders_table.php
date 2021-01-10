<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateOrdersTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('staff_id');

            $table->unsignedBigInteger('customer_id');

            $table->unsignedBigInteger('fedex_order_id');

            $table->unsignedBigInteger('pickup_id');

            $table->unsignedBigInteger('shipment_id');

            $table->decimal('price',10,2);

            $table->decimal('payed_price',10,2);

            $table->enum('status',['created', 'picked_up', 'waiting', 'pending', 'shipping',
                'shipped', 'delivering', 'delivered', 'canceled']);

            $table->enum('payment_status',['payed','debt']);

            $table->integer('total_boxes')->default(0);

            $table->float('total_weight_boxes')->default(0);

            $table->integer('total_delivered_boxes')->default(0);

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();

            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('fedex_order_id')->references('id')->on('fedex_orders')->onDelete('cascade');

            $table->foreign('pickup_id')->references('id')->on('pickups')->onDelete('cascade');

            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
}

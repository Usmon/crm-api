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

            $table->unsignedBigInteger('fedex_order_id')->nullable();

            $table->unsignedBigInteger('pickup_id')->nullable();

            $table->unsignedBigInteger('shipment_id')->nullable();

            $table->unsignedBigInteger('sender_id');

            $table->unsignedBigInteger('recipient_id');

            $table->unsignedBigInteger('status_id');

            $table->unsignedBigInteger('payment_status_id');

            $table->json('type');

            $table->decimal('price',10,2);

            $table->decimal('payed_price',10,2)->default(0);

            $table->integer('total_boxes')->default(0);

            $table->float('total_weight_boxes')->default(0);

            $table->integer('total_delivered_boxes')->default(0);

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();

            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('fedex_order_id')->references('id')->on('fedex_orders')->onDelete('cascade');

            $table->foreign('pickup_id')->references('id')->on('pickups')->onDelete('cascade');

            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
            
            $table->foreign('sender_id')->references('id')->on('senders')->onDelete('cascade');

            $table->foreign('recipient_id')->references('id')->on('recipients')->onDelete('cascade');
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

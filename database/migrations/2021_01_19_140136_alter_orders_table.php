<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class AlterOrdersTable extends Migration
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
        Schema::table($this->table, function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable()->change();

            $table->unsignedBigInteger('fedex_order_id')->nullable()->change();

            $table->unsignedBigInteger('pickup_id')->nullable()->change();

            $table->unsignedBigInteger('shipment_id')->nullable()->change();

            $table->foreignId('sender_id')->constrained();

            $table->foreignId('recipient_id')->constrained();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->change();

            $table->unsignedBigInteger('fedex_order_id')->change();

            $table->unsignedBigInteger('pickup_id')->change();

            $table->unsignedBigInteger('shipment_id')->change();

            $table->dropColumn(['sender_id', 'recipient_id']);
        });
    }
}

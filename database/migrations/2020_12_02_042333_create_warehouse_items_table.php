<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateWarehouseItemsTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'warehouse_items';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('customer_id');

            $table->unsignedBigInteger('shipment_id');

            $table->string('name');

            $table->integer('init_quantity')->default('0');

            $table->integer('quantity')->default('0');

            $table->decimal('init_weight',10,2)->nullable();

            $table->decimal('weight',10,2);

            $table->decimal('total_price',10,2);

            $table->decimal('payed',10,2);

            $table->string('note');

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();

            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');

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

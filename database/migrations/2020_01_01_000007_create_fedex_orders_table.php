<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateFedexOrdersTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'fedex_orders';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->decimal('price', 10, 2);

            $table->decimal('discount_price', 10, 2)->nullable();

            $table->enum('service_type', ['ground'])->default('ground');

            $table->string('tracking_number')->nullable();

            $table->string('label_file')->nullable();

            $table->string('transit_time')->nullable();

            $table->enum('status', ['pending', 'arrived'])->default('pending');

            $table->unsignedBigInteger('staff_id');

            $table->unsignedBigInteger('customer_id');

            $table->timestamp('arrived_at')->nullable();

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->unique('tracking_number');

            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
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

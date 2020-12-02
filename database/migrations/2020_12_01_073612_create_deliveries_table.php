<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateDeliveriesTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'deliveries';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('order_id');

            $table->unsignedBigInteger('driver_id');

            $table->enum('status', ['pending', 'delivering', 'delivered']);

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {

            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');


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

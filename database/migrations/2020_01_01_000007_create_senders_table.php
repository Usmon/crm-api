<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateSendersTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'senders';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('customer_id');

            $table->unsignedBigInteger('city_id');

            $table->unsignedBigInteger('region_id');

            $table->unsignedBigInteger('address_id');

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();
        });
        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('city_id')->references('id')->on('cities')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('region_id')->references('id')->on('regions')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('address_id')->references('id')->on('addresses')->cascadeOnUpdate()->cascadeOnDelete();
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

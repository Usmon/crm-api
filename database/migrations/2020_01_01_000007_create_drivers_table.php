<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateDriversTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'drivers';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('creator_id');

            $table->unsignedBigInteger('user_id');

            $table->string('phone');

            $table->unsignedBigInteger('city_id');

            $table->unsignedBigInteger('region_id');

            $table->unsignedBigInteger('address_id');

            $table->string('car_model')->nullable();

            $table->string('car_number')->nullable();

            $table->string('license')->nullable();

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('creator_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();

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

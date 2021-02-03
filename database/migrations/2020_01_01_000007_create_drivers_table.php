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

            $table->string('name');

            $table->string('phone');

            $table->string('email');

            $table->string('region');

            $table->string('city');

            $table->string('zip_or_post_code');

            $table->string('address');

            $table->string('car_model')->nullable();

            $table->string('car_number')->nullable();

            $table->string('license')->nullable();

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->unique('email');

            $table->foreign('creator_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
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

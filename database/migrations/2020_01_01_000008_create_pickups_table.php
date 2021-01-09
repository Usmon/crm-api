<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreatePickupsTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'pickups';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('note');

            $table->string('bring_address');

            $table->dateTime('bring_datetime_start');

            $table->dateTime('bring_datetime_end');

            $table->unsignedBigInteger('staff_id');

            $table->unsignedBigInteger('driver_id');

            $table->unsignedBigInteger('customer_id');

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();

            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('staff_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('driver_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('customer_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('deleted_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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

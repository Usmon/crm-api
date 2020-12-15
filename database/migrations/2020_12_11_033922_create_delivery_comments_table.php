<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateDeliveryCommentsTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'delivery_comments';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('delivery_id');

            $table->unsignedBigInteger('owner_id');

            $table->text('comment');

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();

            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table){
            $table->foreign('delivery_id')->references('id')->on('deliveries')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('owner_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

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

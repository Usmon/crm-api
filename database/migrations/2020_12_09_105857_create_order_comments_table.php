<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateOrderCommentsTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'order_comments';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('order_id');

            $table->unsignedBigInteger('owner_id');

            $table->text('comment');

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();

            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table){
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');

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

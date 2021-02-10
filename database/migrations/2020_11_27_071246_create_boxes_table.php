<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateBoxesTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'boxes';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('order_id');

            $table->unsignedBigInteger('status_id');

            $table->float('weight');

            $table->float('additional_weight');

            $table->string('box_image')->nullable();

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        
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

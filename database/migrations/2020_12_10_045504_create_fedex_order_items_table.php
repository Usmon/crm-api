<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateFedexOrderItemsTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'fedex_order_items';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('fedex_order_id');

            $table->double('weight',10,2);

            $table->integer('width')->nullable();

            $table->integer('height')->nullable();

            $table->integer('length')->nullable();

            $table->double('service_price',10,2);

            $table->double('service_discount_price',10,2);

            $table->string('label_file_name');

            $table->string('barcode');

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();

            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table){
            $table->foreign('fedex_order_id')->references('id')->on('fedex_orders')->onUpdate('cascade')->onDelete('cascade');

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

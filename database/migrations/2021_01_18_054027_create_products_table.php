<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateProductsTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('order_id');

            $table->string('name');

            $table->enum('status',[
                'created',

                'waiting in office',

                'at the office',

                'shipment',

                'transit',

                'customs',

                'tashkent',

                'delivering',

                'delivered'
            ]);

            $table->integer('quantity');

            $table->float('price',10,2);

            $table->float('weight',10,2);

            $table->enum('type_weight',['lb','kg']);

            $table->string('image')->nullable();

            $table->string('note')->nullable();

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();

            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('deleted_by')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
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

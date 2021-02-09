<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateBoxItemsTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'box_items';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('box_id');

            $table->string('name');

            $table->tinyInteger('quantity');

            $table->float('price');

            $table->float('weight');

            $table->string('made_in');

            $table->string('note');

            $table->tinyInteger('is_additional')->default(0);

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table){
            $table->foreign('box_id')->references('id')->on('boxes')->onUpdate('cascade')->onDelete('cascade');
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

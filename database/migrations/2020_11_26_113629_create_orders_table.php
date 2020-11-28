<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateOrdersTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();
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

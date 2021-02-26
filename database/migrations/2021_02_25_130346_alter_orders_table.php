<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class AlterOrdersTable extends Migration
{
    /**
     * @var string $table
     */
    protected $table = 'orders';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->decimal('price_insurance')->default(0);

            $table->decimal('price_warehouse')->default(0);

            $table->decimal('price_delivery')->default(0);

            $table->decimal('price_total')->default(0);

            $table->decimal('price_debt')->default(0);

            $table->integer('weight_rate')->default(0);

            $table->unsignedBigInteger('payment_type_id')->nullable();

            $table->foreign('payment_type_id')
                    ->references('id')
                    ->on('payment_types')
                    ->onDelete('cascade');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn('price_insurance');

            $table->dropColumn('price_warehouse');

            $table->dropColumn('price_delivery');

            $table->dropColumn('price_total');

            $table->dropColumn('price_debt');

            $table->dropColumn('weight_rate');

            $table->dropForeign('orders_payment_type_id_foreign');

            $table->dropColumn('payment_type_id');
        });
    }
}

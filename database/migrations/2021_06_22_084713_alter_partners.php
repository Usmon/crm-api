<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class AlterPartners extends Migration
{
    /**
     * @property string
     */
    private string $table = 'partners';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->string('address')->nullable()->change();

            $table->unsignedBigInteger('city_id')->nullable()->change();

            $table->unsignedBigInteger('creator_id')->nullable();

            $table->decimal('weight_price')->default(0);

            $table->decimal('warehouse_price')->default(0);

            $table->decimal('pickup')->default(0);

            $table->decimal('delivery')->default(0);

            $table->decimal('discount_price')->default(0);

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->string('address')->change();

            $table->unsignedBigInteger('city_id')->change();

            $table->dropColumn('weight_price');

            $table->dropColumn('warehouse_price');

            $table->dropColumn('pickup');

            $table->dropColumn('delivery');

            $table->dropColumn('discount_price');

            $table->dropForeign('creator_id');

            $table->dropColumn('creator_id');
        });
    }
}

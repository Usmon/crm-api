<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class AlterDriversTableAddPartnerId extends Migration
{
    /**
     * @var string
     */
    private string $table = 'drivers';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table($this->table, function (Blueprint $table) {

            $table->unsignedBigInteger('partner_id')->default(1);

        });

        Schema::table($this->table, function (Blueprint $table) {

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');

        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table($this->table, function (Blueprint $table) {

            $table->dropIndex(['partner_id']);

            $table->dropColumn('partner_id');

        });
    }
}

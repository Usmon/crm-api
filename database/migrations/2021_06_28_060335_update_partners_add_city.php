<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class UpdatePartnersAddCity extends Migration
{
    /**
     * @var string
     */
    private string $table = 'partners';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->string('address_additional')->after('address')->nullable();

            $table->integer('code')->after('address_additional')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn('code');

            $table->dropColumn('address_additional');
        });
    }
}

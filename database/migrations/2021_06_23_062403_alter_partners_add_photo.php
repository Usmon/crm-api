<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class AlterPartnersAddPhoto extends Migration
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
            $table->string('photo')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
}

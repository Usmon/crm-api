<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class AddressAddZipCode extends Migration
{
    /**
     * @var string
     */
    private string $table = 'addresses';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table($this->table, function(Blueprint $table) {

            $table->integer('code')->nullable()->after('second_address');

        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table($this->table, function(Blueprint $table) {

            $table->dropColumn('code');

        });
    }
}

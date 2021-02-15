<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class UpdateUsersTable extends Migration
{

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table($this->table, function(Blueprint $table) {
            $table->unsignedBigInteger('partner_id')->nullable();

            $table->foreign('partner_id')->references('id')->on('partners');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table($this->table, function(Blueprint $table) {
            $table->dropForeign(['partner_id']);

            $table->dropColumn('partner_id');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreatePartners extends Migration
{
    /**
     * @var string
     */
    protected $table = 'partners';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('city_id');

            $table->string('name');

            $table->string('description')->nullable();

            $table->string('address');

            $table->string('phone')->nullable();

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();
        });
        
        Schema::table($this->table, function (Blueprint $table) {

            $table->foreign('city_id')->references('id')->on('cities');

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

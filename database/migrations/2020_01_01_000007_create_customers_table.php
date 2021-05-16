<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateCustomersTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'customers';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id')->unique();

            $table->unsignedBigInteger('creator_id');

            $table->unsignedBigInteger('referral_id')->nullable();

            $table->string('passport')->default('0');

            $table->double('balance')->default(0);

            $table->double('debt')->default(0);

            $table->double('limit')->default(1000);

            $table->date('birth_date')->nullable();

            $table->text('note')->nullable();

            $table->timestamps();

            $table->timestamp('deleted_at')->nullable();

            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('creator_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('referral_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('deleted_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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

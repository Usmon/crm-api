<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateMessagesTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'messages';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('sender_id');

            $table->unsignedBigInteger('receiver_id');

            $table->string('body');

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {

            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
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

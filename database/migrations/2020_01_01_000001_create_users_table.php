<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateUsersTable extends Migration
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
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('login');

            $table->string('email');

            $table->string('password');

            $table->string('full_name');

            $table->jsonb('profile');

            $table->string('reset_token', 100)->nullable();

            $table->string('verify_token', 100)->nullable();

            $table->string('remember_token', 100)->nullable();

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->unique('login');

            $table->unique('email');
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

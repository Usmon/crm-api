<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

final class CreateUserRoleTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'user_role';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');

            $table->unsignedBigInteger('role_id');

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->unique([
                'user_id',

                'role_id',
            ]);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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

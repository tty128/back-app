<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',60);
            $table->string('nickname',60)->nullable();
            $table->string('email',200)->unique();
            $table->timestamp('email_verified_at',200)->nullable();
            $table->string('password');
            $table->string('status',16)->default('user');
            $table->timestamps();
            $table->rememberToken();
            $table->string('api_token', 60)->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('author')->default(0);
            $table->unsignedBigInteger('update_author')->nullable();
            $table->timestamps(0);
            $table->text('title');
            $table->longText('body');
            $table->string('status',20)->default('private');
            $table->string('category', 64)->default('uncategorized');
            $table->string('eyecatch', 64)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}

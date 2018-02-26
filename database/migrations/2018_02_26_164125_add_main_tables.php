<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();

        });

        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('type')->nullable();
            $table->text('content')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->dateTime('published_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('projects');
    }
}

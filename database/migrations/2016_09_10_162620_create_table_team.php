<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('team_id')->unique();
            $table->string('name');
            $table->string('career');
            $table->unsignedInteger('avatar_id')->nullable();
            $table->foreign('avatar_id')->references('id')->on('file')->onDelete('set null');
            $table->string('slug')->unique();
            $table->integer('order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team');
    }
}

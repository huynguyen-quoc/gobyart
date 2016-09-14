<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMusicCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('music_category', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('category_id')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('artist_type_id');
            $table->foreign('artist_type_id')->references('id')->on('artist_type')->onDelete('cascade');
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
        Schema::dropIfExists('music_category');
    }
}

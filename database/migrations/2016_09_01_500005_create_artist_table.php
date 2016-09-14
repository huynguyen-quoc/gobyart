<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('artist_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name');
            $table->text('description');
            $table->string('slug')->unique();
            $table->text('extra_information')->nullable();
            $table->date('date_of_birth');
            $table->integer('status')->default(0);
            $table->unsignedInteger('music_category_id');
            $table->foreign('music_category_id')->references('id')->on('music_category')->onDelete('cascade');
            $table->unsignedInteger('avatar_id')->nullable();
            $table->foreign('avatar_id')->references('id')->on('file')->onDelete('set null');
//            $table->unsignedInteger('category_id')->nullable();
//            $table->foreign('category_id')->references('id')->on('artist_category')->onDelete('set null');
            $table->unsignedInteger('seo_id')->nullable();
            $table->foreign('seo_id')->references('id')->on('seo_option')->onDelete('set null');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
            $table->unsignedInteger('user_id_edited')->nullable();
            $table->foreign('user_id_edited')->references('id')->on('user')->onDelete('set null');
            $table->timestamps();
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
        Schema::dropIfExists('artist');
    }
}

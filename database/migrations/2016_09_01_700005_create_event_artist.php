<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventArtist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_artist', function (Blueprint $table) {
            $table->unsignedInteger('event_id');
            $table->foreign('event_id')->references('id')->on('event')->onDelete('cascade');
            $table->unsignedInteger('artist_id');
            $table->foreign('artist_id')->references('id')->on('artist')->onDelete('cascade');
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
        Schema::dropIfExists('event_artist');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'artist_file', function(Blueprint $table){
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('file')->onDelete('cascade');
            $table->unsignedInteger('artist_id');
            $table->foreign('artist_id')->references('id')->on('artist')->onDelete('cascade');
            $table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artist_file');
        //
    }
}

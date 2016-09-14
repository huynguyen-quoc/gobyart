<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateFileGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'file_group', function(Blueprint $table){
            $table->unsignedInteger('file_id');
            $table->foreign('file_id')->references('id')->on('file')->onDelete('cascade');
            $table->unsignedInteger('group_id');
            $table->foreign('group_id')->references('id')->on('group')->onDelete('cascade');
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
        Schema::dropIfExists('file_group');
    }
}

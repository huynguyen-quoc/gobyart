<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'file', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('file_id')->unique();
            $table->string('original_name');
            $table->string('extension');
            $table->integer('width');
            $table->integer('height');
            $table->string('link')->nullable();
            $table->string('slug')->unique();
            $table->unsignedInteger('seo_id')->nullable();
            $table->foreign('seo_id')->references('id')->on('seo_option');
            $table->integer('status')->default(1);
            $table->integer('order');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::drop('file');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

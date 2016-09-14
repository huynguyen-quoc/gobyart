<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_option', function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('seo_id')->unique();
            $table->string('meta')->nullable();
            $table->string('keywords', 200)->nullable();
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
        Schema::dropIfExists('seo_option');
    }
}

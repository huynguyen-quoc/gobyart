<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_option', function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->longText('value');
            $table->string('option_input', 100)->default('text');
            $table->string('type', 50)->default('SITE');
            $table->integer('order')->default(1);
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
        Schema::dropIfExists('site_option');
    }
}

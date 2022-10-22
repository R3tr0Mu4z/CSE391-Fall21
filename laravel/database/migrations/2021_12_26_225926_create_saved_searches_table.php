<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_searches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('save_search_name');
            $table->integer('bed')->nullable();
            $table->integer('bath')->nullable();
            $table->string('city')->nullable();
            $table->longText('coords')->nullable();
            $table->string('layer_type')->nullable();
            $table->string('district')->nullable();
            $table->string('min')->nullable();
            $table->string('max')->nullable();
            $table->string('postal')->nullable();
            $table->string('property_type')->nullable();
            $table->string('img')->nullable();
            $table->integer('user')->unsigned();
            $table->foreign('user')->references('id')->on('users');
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
        Schema::dropIfExists('saved_searches');
    }
}

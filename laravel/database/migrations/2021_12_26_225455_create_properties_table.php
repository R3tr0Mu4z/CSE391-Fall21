<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('street');
            $table->string('district');
            $table->string('city');
            $table->string('postal');
            $table->integer('cost');
            $table->string('type');
            $table->integer('bath');
            $table->integer('bed');
            $table->string('size');
            $table->longText('description')->nullable();
            $table->string('house_details')->nullable();
            $table->string('flat_details')->nullable();
            $table->longText('img_urls');
            $table->string('lat');
            $table->string('lng');
            $table->point('loc');
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
        Schema::dropIfExists('properties');
    }
}

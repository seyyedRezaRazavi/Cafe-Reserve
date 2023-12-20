<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->time('time');
            $table->integer('zarfiat');

            $table->bigInteger('location_id')->unsigned();

            $table->timestamps();
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_places');
    }
}

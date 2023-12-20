<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_registers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer(('tedad'));

            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_registers');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('state')->default(0)->comment("-1:Cancel / 0:Reserved / 1:Done");
            $table->integer('number');

            $table->bigInteger('game_id')->unsigned()->nullable();
            $table->text('food')->default('');

            $table->bigInteger('time_place_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('time_place_id')->references('id')->on('time_places');
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
        Schema::dropIfExists('reserves');
    }
}

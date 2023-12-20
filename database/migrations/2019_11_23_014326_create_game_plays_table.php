<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamePlaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_plays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->boolean('state')->default(0)->comment('0:unknown / 1:winner / 2:secend winner / 3:third winner');

            $table->bigInteger('game_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games');
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
        Schema::dropIfExists('game_plays');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->string('subtitle',120)->nullable();
            $table->dateTime('date');
            $table->integer('zarfiat')->default(0);
            $table->string('zarfiat_unit',10)->default("نفر")->comment(" نفر / تیم");
            $table->text('desc')->nullable();
            $table->integer('vorodi_cost');
            $table->string('picture')->nullable();
            $table->bigInteger('event_label_id')->unsigned();

            $table->timestamps();

            $table->foreign('event_label_id')->references('id')->on('event_labels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();

            $table->string('user_name')->nullable();
            $table->string('tell')->unique()->nullable();
            $table->string('laghab')->default('تازه وارد')->nullable();
            $table->string('type')->default("basic")->nullable();
            $table->string('pic')->nullable();


            $table->timestamp('last_sms')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('sms_token',60)->nullable();
            $table->integer('incorrect_check')->default(0);
            $table->text('api_token')->nullable();

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
        Schema::dropIfExists('users');
    }
}

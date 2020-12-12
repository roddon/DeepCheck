<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPlanChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscription_checks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('user_subscription_id');
            $table->integer('no_of_doc')->nullable();
            $table->integer('no_of_detector')->nullable();
            $table->integer('no_of_verification')->nullable();
            $table->integer('no_of_onboarding')->nullable();
            $table->integer('no_of_safepay')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_subscription_id')->references('id')->on('user_subscription');
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
        Schema::dropIfExists('user_subscription_checks');
    }
}

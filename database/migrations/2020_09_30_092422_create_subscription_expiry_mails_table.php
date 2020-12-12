<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionExpiryMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_expiry_mails', function (Blueprint $table) {
            $table->id();
            $table->text('seven_days_before_exp')->nullable();
            $table->text('three_days_before_exp')->nullable();
            $table->text('one_days_before_exp')->nullable();
            $table->text('one_days_after_exp')->nullable();
            $table->text('three_days_after_exp')->nullable();
            $table->text('seven_days_after_exp')->nullable();
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
        Schema::dropIfExists('subscription_expiry_mails');
    }
}

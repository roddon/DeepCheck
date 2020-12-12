<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->decimal('total',15,2)->default(0);
            $table->integer('no_of_days')->nullable();
            $table->integer('no_of_doc_check')->nullable();
            $table->integer('no_of_detector_records')->nullable();
            $table->integer('no_of_verification')->nullable();
            $table->integer('no_of_onboarding')->nullable();
            $table->integer('no_of_live_protect')->nullable();
            $table->integer('free_trial_months')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('subscription_plans');
    }
}

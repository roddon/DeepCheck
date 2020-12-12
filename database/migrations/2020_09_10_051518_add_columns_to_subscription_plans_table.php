<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn('stripe_plan');
            $table->dropColumn('total');
            $table->dropColumn('no_of_days');
            $table->dropColumn('no_of_doc_check');
            $table->dropColumn('no_of_detector_records');
            $table->dropColumn('no_of_verification');
            $table->dropColumn('no_of_onboarding');
            $table->dropColumn('no_of_live_protect');
            $table->dropColumn('free_trial_months');
        });

        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->integer('trial_days')->nullable();
            $table->integer('trial_days_doc_numbers')->nullable();
            $table->tinyInteger('include_check_invoice')->default(0);
            $table->tinyInteger('include_supplier_check')->default(0);
            $table->tinyInteger('include_safe_payout')->default(0);
            $table->tinyInteger('include_detector_records')->default(0);
            $table->tinyInteger('include_onboarding')->default(0);
            $table->string('slug');
        });

        Schema::create('subscription_plan_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_plan_id');
            $table->integer('no_of_records_count');
            $table->integer('price');
        });

        Schema::table('user_subscription', function (Blueprint $table) {
            $table->date('updated_start_date')->nullable();
            $table->tinyInteger('is_active')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn('trial_days');
            $table->dropColumn('trial_days_doc_numbers');
            $table->dropColumn('include_check_invoice');
            $table->dropColumn('include_supplier_check');
            $table->dropColumn('include_safe_payout');
            $table->dropColumn('include_detector_records');
            $table->dropColumn('include_onboarding');
            $table->dropColumn('slug');

            $table->string('stripe_plan')->nullable();
            $table->decimal('total',15,2)->default(0);
            $table->integer('no_of_days')->nullable();
            $table->integer('no_of_doc_check')->nullable();
            $table->integer('no_of_detector_records')->nullable();
            $table->integer('no_of_verification')->nullable();
            $table->integer('no_of_onboarding')->nullable();
            $table->integer('no_of_live_protect')->nullable();
            $table->integer('free_trial_months')->nullable();
        });

        Schema::dropIfExists('subscription_plan_records');

        Schema::table('user_subscription', function (Blueprint $table) {
            $table->dropColumn('updated_start_date');
            $table->dropColumn('is_active');
        });
    }
}

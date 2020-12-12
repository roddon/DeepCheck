<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUserSubscriptionChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_subscription_checks', function (Blueprint $table) {
            $table->dropColumn('no_of_doc');
            $table->dropColumn('no_of_detector');
            $table->dropColumn('no_of_verification');
            $table->dropColumn('no_of_safepay');

            $table->integer('no_of_check_invoice')->nullable();
            $table->integer('no_of_supplier_check')->nullable();
            $table->integer('no_of_safe_payout')->nullable();
            $table->integer('no_of_detector_records')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_subscription_checks', function (Blueprint $table) {
            $table->integer('no_of_doc')->nullable();
            $table->integer('no_of_detector')->nullable();
            $table->integer('no_of_verification')->nullable();
            $table->integer('no_of_safepay')->nullable();

            $table->dropColumn('no_of_check_invoice');
            $table->dropColumn('no_of_supplier_check');
            $table->dropColumn('no_of_safe_payout');
            $table->dropColumn('no_of_detector_records');
        });
    }
}

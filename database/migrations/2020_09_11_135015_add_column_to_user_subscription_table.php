<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUserSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_subscription', function (Blueprint $table) {
            $table->decimal('paid_price', 8, 2);
            $table->unsignedBigInteger('subscription_plan_record_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_subscription', function (Blueprint $table) {
            $table->dropColumn('paid_price');
            $table->dropColumn('subscription_plan_record_id');
        });
    }
}

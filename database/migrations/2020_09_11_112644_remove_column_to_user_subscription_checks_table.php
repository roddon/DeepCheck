<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnToUserSubscriptionChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_subscription_checks', function (Blueprint $table) {
            $table->dropForeign('user_subscription_checks_user_subscription_id_foreign');
            $table->dropColumn('user_subscription_id');
            $table->string('user_subscription_ids');
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
            $table->unsignedBigInteger('user_subscription_id');
            $table->foreign('user_subscription_id')->references('id')->on('user_subscription');
            $table->dropColumn('user_subscription_ids');
        });
    }
}

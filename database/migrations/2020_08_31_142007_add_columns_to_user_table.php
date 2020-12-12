<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('card_number')->nullable();
            $table->string('cvv')->nullable();
            $table->string('exp_month')->nullable();
            $table->string('exp_year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("card_number");
            $table->dropColumn("cvv");
            $table->dropColumn("exp_month");
            $table->dropColumn("exp_year");
        });
    }
}

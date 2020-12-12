<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->tinyInteger('review_status')->nullable()->comment('0:admin review, 1: approved by admin');
            $table->string('phone')->nullable();
            $table->string('web')->nullable();
            $table->date('date_of_request')->nullable();
            $table->string('tax')->nullable();
        });

        Schema::table('media_training', function (Blueprint $table) {
            $table->string('corrected_phone')->nullable();
            $table->string('corrected_web')->nullable();
            $table->string('corrected_tax')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_training', function (Blueprint $table) {
            $table->dropColumn('corrected_phone');
            $table->dropColumn('corrected_web');
            $table->dropColumn('corrected_tax');
        });

        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('review_status');
            $table->dropColumn('phone');
            $table->dropColumn('web');
            $table->dropColumn('date_of_request');
            $table->dropColumn('tax');
        });
    }
}

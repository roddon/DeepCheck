<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyncreportPlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syncreport_pl', function (Blueprint $table) {
            $table->id();
            $table->string('cust_no');
            $table->string('unique_frenss_id')->nullable();
            $table->text('pl_data')->nullable();
            $table->timestamp('datetime');
            $table->string('account_name')->nullable();
            $table->string('account_type');
            $table->string('detail_acc_type')->nullable();
            $table->string('frenns_cat')->nullable();
            $table->string('value')->nullable();
            $table->string('variable')->nullable();
            $table->string('variable_value')->nullable();
            $table->string('report_type', 80)->nullable();
            $table->string('period', 100)->default('monthly');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->string('platform', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syncreport_pl');
    }
}

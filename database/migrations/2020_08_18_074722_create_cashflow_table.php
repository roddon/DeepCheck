<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashflowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashflow', function (Blueprint $table) {
            $table->id();
            $table->string('frenns_id', 45)->nullable();
            $table->string('month', 45)->nullable();
            $table->string('year', 45)->nullable();
            $table->string('revenue', 45)->nullable();
            $table->string('cashflow', 45)->nullable();
            $table->string('profit_loss', 45)->nullable();
            $table->string('fluctuation', 45)->nullable();
            $table->string('trendcashflow', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashflow');
    }
}

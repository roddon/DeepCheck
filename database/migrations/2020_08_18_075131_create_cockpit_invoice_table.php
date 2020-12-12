<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCockpitInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cockpit_invoice', function (Blueprint $table) {
            $table->id();
            $table->string('cust_no')->nullable();
            $table->string('syncsupplier_id')->nullable();
            $table->unsignedBigInteger('syncinvoice_id')->nullable();
            $table->string('variable_analysis')->nullable();
            $table->string('value')->nullable();
            $table->tinyInteger('decision')->nullable();
            $table->string('path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cockpit_invoice');
    }
}

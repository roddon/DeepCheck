<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCockpitCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cockpit_customer', function (Blueprint $table) {
            $table->id();
            $table->string('cust_no')->nullable();
            $table->string('variable_analysis')->nullable();
            $table->string('value')->nullable();
            $table->string('decision')->nullable();
            $table->string('path')->nullable();
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
        Schema::dropIfExists('cockpit_customer');
    }
}

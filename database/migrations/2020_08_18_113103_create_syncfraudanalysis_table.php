<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyncfraudanalysisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syncfraudanalysis', function (Blueprint $table) {
            $table->id();
            $table->string('cust_no');
            $table->timestamp('datetime');
            $table->string('area');
            $table->string('period');
            $table->date('date_from');
            $table->date('date_to');
            $table->double('value');
            $table->string('anomly');
            $table->string('decision');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syncfraudanalysis');
    }
}

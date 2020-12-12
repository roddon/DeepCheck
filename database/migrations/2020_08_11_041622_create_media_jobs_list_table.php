<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaJobsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_jobs_list', function (Blueprint $table) {
            $table->id();
            $table->string('jobname')->nullable();
            $table->tinyInteger('proc_order')->nullable();
            $table->string('file_path')->nullable();
            $table->string('table_name')->nullable();
            $table->string('par1')->nullable();
            $table->string('par2')->nullable();
            $table->string('par3')->nullable();
            $table->string('document_system')->nullable();
            $table->tinyInteger('max_no_processes')->nullable();
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
        Schema::dropIfExists('media_jobs_list');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_media', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('document_system')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->timestamps();

            $table->foreign('media_id')->references('id')->on('media');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmp_media');
    }
}

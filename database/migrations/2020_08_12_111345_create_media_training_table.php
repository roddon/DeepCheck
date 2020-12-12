<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_training', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('name');
            $table->string('file_name');
            $table->string('name_entity')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('post_code')->nullable();
            $table->string('city')->nullable();
            $table->string('Country')->nullable();
            $table->string('Bank_account')->nullable();
            $table->string('VAT_Number')->nullable();
            $table->string('VAT')->nullable();
            $table->string('Email')->nullable();
            $table->string('Total_price')->nullable();
            $table->longText('big_text')->nullable();
            $table->string('corrected_name_entity')->nullable();
            $table->string('corrected_address1')->nullable();
            $table->string('corrected_address2')->nullable();
            $table->string('corrected_post_code')->nullable();
            $table->string('corrected_city')->nullable();
            $table->string('corrected_country')->nullable();
            $table->string('corrected_bank_account')->nullable();
            $table->string('corrected_VAT_number')->nullable();
            $table->string('corrected_VAT')->nullable();
            $table->string('corrected_email')->nullable();
            $table->string('corrected_total_price')->nullable();
            $table->string('corrected_quantity')->nullable();
            $table->string('corrected_big_text')->nullable();
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
        Schema::dropIfExists('media_training');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->morphs('model');
            $table->uuid('uuid')->nullable();
            $table->string('collection_name');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->string('disk');
            $table->string('conversions_disk')->nullable();
            $table->unsignedBigInteger('size');
            $table->json('manipulations');
            $table->json('custom_properties');
            $table->json('responsive_images');
            $table->string('doc_status')->nullable();
            $table->string('comment')->nullable();
            $table->text('file_path')->nullable();
            $table->text('file_url')->nullable();
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
            $table->string('Quantity')->nullable();
            $table->string('analysis_status')->nullable();
            $table->tinyInteger('processing')->nullable();
            $table->tinyInteger('processed')->nullable();
            $table->tinyInteger('error')->nullable();
            $table->tinyInteger('on_error')->nullable();
            $table->tinyInteger('new_DRS')->nullable();
            $table->string('jobname')->nullable();
            $table->string('document_system')->nullable();
            $table->string('syncclient')->nullable();
            $table->longText('big_text')->nullable();
            $table->boolean('is_run')->default(false);
            $table->unsignedInteger('order_column')->nullable();

            $table->nullableTimestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}

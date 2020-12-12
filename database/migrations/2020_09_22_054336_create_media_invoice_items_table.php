<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('media_id');
            $table->string('description')->nullable();
            $table->string('product_code')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('price',8,2)->nullable();
            $table->decimal('total_price',8,2)->nullable()->comment('excluding tax');
            $table->decimal('tax',8,2)->nullable();
            $table->decimal('total_amount',8,2)->nullable()->comment('including tax');
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
        Schema::dropIfExists('media_invoice_items');
    }
}

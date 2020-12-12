<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrueLayerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('true_layer_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('simp_id', 100)->nullable();
            $table->text('auth_uri')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('currency', 6)->nullable();
            $table->string('beneficiary_reference', 30)->nullable();
            $table->string('beneficiary_name', 30)->nullable();
            $table->string('beneficiary_sort_code', 30)->nullable();
            $table->string('beneficiary_account_number', 100)->nullable();
            $table->string('remitter_reference', 30)->nullable();
            $table->string('redirect_uri')->nullable();
            $table->string('webhook_uri')->nullable();
            $table->string('created_date')->nullable();
            $table->string('remitter_provider_id', 30)->nullable();
            $table->string('status', 30)->nullable();
            $table->string('invoices_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('true_layer_payments');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyncinoviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syncinvoice', function (Blueprint $table) {
            $table->id();
            $table->string('cust_no');
            $table->string('unique_cust_no', 200)->nullable();
            $table->integer('syncsupplier_id');
            $table->string('type');
            $table->date('issue_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('collection_date');
            $table->date('creation_date');
            $table->date('last_updated')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('postcode');
            $table->string('city');
            $table->string('country');
            $table->string('company_number')->nullable();
            $table->string('vat_registration_number')->nullable();
            $table->string('company_account_number')->nullable();
            $table->string('account_number')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('delivery_date', 100)->nullable();
            $table->string('currency')->nullable();
            $table->float('amount')->nullable()->default(0);
            $table->float('vat_amount')->nullable()->default(0);
            $table->float('outstanding_amount')->nullable()->default(0);
            $table->string('paid');
            $table->string('pay_date', 100)->nullable();
            $table->string('invoiceid')->nullable();
            $table->string('customerId')->nullable();
            $table->string('updatedId');
            $table->string('updated_at')->nullable();
            $table->string('flags', 45)->nullable();
            $table->string('bs_call')->nullable();
            $table->string('bs_put')->nullable();
            $table->tinyInteger('process_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syncinvoice');
    }
}

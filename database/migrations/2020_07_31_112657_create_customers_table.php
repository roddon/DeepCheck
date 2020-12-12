<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name', '100')->nullable();
            $table->string('cust_no', 20)->nullable();
            $table->string('email', 250)->nullable();
            $table->string('account_number', 50)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->tinyInteger('gender')->default(0)->comment('0=not specify,1=male,2=female');
            $table->string('contact_number', 20)->nullable();
            $table->string('passport_number', 50)->nullable();
            $table->string('passport_photo')->nullable();
            $table->string('capture_photo')->nullable();
            $table->dateTime('date_of_issue')->nullable();
            $table->dateTime('date_of_expiry')->nullable();
            $table->date('validity_through')->nullable();
            $table->dateTime('verification_date')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->string('result', 45)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('latitude', 45)->nullable();
            $table->string('longitude', 45)->nullable();
            $table->tinyInteger('bank_account_status')->default(0)->comment('0=pending approval,1=approved,2=failed');
            $table->tinyInteger('document_status')->default(0)->comment('0=pending approval,1=approved,2=failed');
            $table->tinyInteger('status')->default(0)->comment('0=pending approval,1=approved,2=failed');
            $table->string('verification_token')->nullable();
            $table->string('company_number', 20)->nullable();
            $table->string('company_name')->nullable();
            $table->string('vat_number', 20)->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('post_code', 10)->nullable();
            $table->string('i_ban_number', 30)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('sort_code', 10)->nullable();
            $table->string('currency_code', 10)->nullable();

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
        Schema::dropIfExists('customers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            // $table->unsignedInteger('county_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('language_id')->nullable();
            $table->string('name');
            $table->string('sort_code', 20)->nullable();
            $table->string('account_number')->nullable();
            $table->string('company_number');
            $table->string('cust_no')->nullable();
            $table->string('phone_number')->lenght('20')->nullable();
            $table->boolean('status');
            $table->string('vat_number')->nullable();
            $table->string('i_ban_number')->nullable();
            $table->text('website_url')->nullable();
            $table->longText('onboarding_message')->nullable();
            $table->longText('invoice_result_message')->nullable();
            $table->longText('supplier_verification_message')->nullable();
            $table->longText('existing_supplier_message')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('post_code')->length(10)->nullable();
            $table->boolean('is_company_verified')->default(false);
            $table->boolean('is_vat_number_verified')->default(false);
            $table->boolean('is_ban_number_verified')->default(false);
            $table->boolean('is_client_synced')->default(false);
            $table->boolean('is_onboarding')->default(false);
            $table->boolean('is_id_document')->default(false);
            $table->boolean('is_utility_bill_uploaded')->default(false);


            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('country_id')->references('id')->on('countries');
            // $table->foreign('city_id')->references('id')->on('cities');
            // $table->foreign('county_id')->references('id')->on('counties');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('category_id')->references('id')->on('company_cateogries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}

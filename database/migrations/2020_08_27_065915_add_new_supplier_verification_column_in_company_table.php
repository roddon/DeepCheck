<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewSupplierVerificationColumnInCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('new_supplier_verification')->default(false);
            $table->string('onboarding_mail_subject')->default('Onboarding Verification');
            $table->string('invoice_result_mail_subject')->default('Invoice Result');
            $table->string('supplier_verification_mail_subject')->default('Supplier Verification');
            $table->string('existing_supplier_mail_verification')->default('Existing Supplier Verification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('new_supplier_verification');
            $table->dropColumn('onboarding_mail_subject');
            $table->dropColumn('invoice_result_mail_subject');
            $table->dropColumn('supplier_verification_mail_subject');
            $table->dropColumn('existing_supplier_mail_verification');
        });
    }
}

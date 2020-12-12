<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCuolumnsInSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->boolean('is_vat_number_verified')->default(false);
            $table->boolean('is_email_verified')->default(false);
            $table->boolean('is_contact_number_verified')->default(false);
            $table->boolean('is_company_number_verified')->default(false);
            $table->boolean('is_address_verified')->default(false);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('is_vat_number_verified')->default(false);
            $table->boolean('is_email_verified')->default(false);
            $table->boolean('is_contact_number_verified')->default(false);
            $table->boolean('is_company_number_verified')->default(false);
            $table->boolean('is_address_verified')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn('is_vat_number_verified');
            $table->dropColumn('is_email_verified');
            $table->dropColumn('is_contact_number_verified');
            $table->dropColumn('is_company_number_verified');
            $table->dropColumn('is_address_verified');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('is_vat_number_verified');
            $table->dropColumn('is_email_verified');
            $table->dropColumn('is_contact_number_verified');
            $table->dropColumn('is_company_number_verified');
            $table->dropColumn('is_address_verified');
        });
    }
}

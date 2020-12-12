<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMailerColumnsInCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->text('onboarding_mail')->nullable();
            $table->text('check_the_invoice_mail')->nullable();
            $table->text('supplier_verification_mail')->nullable();
            $table->text('existing_supplier_mail')->nullable();
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
            $table->drop('onboarding_mail');
            $table->drop('check_the_invoice_mail');
            $table->drop('supplier_verification_mail');
            $table->drop('existing_supplier_mail');
        });
    }
}

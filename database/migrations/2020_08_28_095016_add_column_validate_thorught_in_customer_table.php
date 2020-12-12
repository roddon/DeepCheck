<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnValidateThorughtInCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->date('validate_through')->nullable();
            $table->string('bank_account_number', 50)->nullable();
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('bank_account_number', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('validate_through');
            $table->dropColumn('bank_account_number');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn('bank_account_number');
        });
    }
}

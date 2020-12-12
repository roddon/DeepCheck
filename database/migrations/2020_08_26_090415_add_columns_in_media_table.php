<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->string('invoicenumber', 50)->nullable();
            $table->decimal('subtotal')->nullable();
            $table->string('language')->nullable();
            $table->string('currency-iso', 30)->nullable();
            $table->string('account_number')->nullable();
            $table->date('issuedate')->nullable();
            $table->date('duedate')->nullable();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('erp_record_reference')->nullable();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->string('cust_no')->after('account_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('invoicenumber');
            $table->dropColumn('subtotal');
            $table->dropColumn('language');
            $table->dropColumn('currency-iso');
            $table->dropColumn('account_number');
            $table->dropColumn('issuedate');
            $table->dropColumn('duedate');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->dropColumn('erp_record_reference');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('cust_no');
        });
    }
}

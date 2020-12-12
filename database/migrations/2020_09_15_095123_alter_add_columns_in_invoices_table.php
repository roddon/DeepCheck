<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnsInInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->date('issue_date')->nullable();
            $table->tinyInteger('source')->comment('1=checkinvoice,2=syncinvoice,3=erp')->nullable();
            $table->tinyInteger('payment_terms')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('issue_date');
            $table->dropColumn('source');
            $table->dropColumn('payment_terms');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnNameCorrectDobCorrectInCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('bank_firstname')->nullable()->after('lastname');
            $table->string('bank_lastname')->nullable()->after('bank_firstname');
            $table->boolean('first_lastname_correct')->nullable()->after('bank_lastname');
            $table->date('bank_dob')->nullable()->after('date_of_birth');
            $table->boolean('dob_correct')->nullable()->after('date_of_birth');
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
            $table->dropColumn('bank_firstname');
            $table->dropColumn('bank_lastname');
            $table->dropColumn('first_lastname_correct');
            $table->dropColumn('bank_dob');
            $table->dropColumn('dob_correct');
        });
    }
}

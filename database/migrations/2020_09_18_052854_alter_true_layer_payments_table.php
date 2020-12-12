<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTrueLayerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('true_layer_payments', function (Blueprint $table) {
            $table->string('payment_type', 30)->nullable()->after('invoices_id');
            $table->string('payment_idempotency_id', 35)->nullable()->after('payment_type');
            $table->string('payment_lifecycle_id', 100)->nullable()->after('payment_idempotency_id');
            $table->string('institution_consent_id', 100)->nullable()->after('payment_lifecycle_id');
            $table->string('tracing_id', 100)->nullable()->after('institution_consent_id');
            $table->string('payment_reference', 20)->nullable()->after('tracing_id');
            $table->string('context_type', 20)->nullable()->after('payment_reference');
            $table->string('payee')->nullable()->after('context_type');
            $table->string('payer')->nullable()->after('payee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('true_layer_payments', function (Blueprint $table) {
            $table->dropColumn('payment_type');
            $table->dropColumn('payment_idempotency_id');
            $table->dropColumn('institution_consent_id');
            $table->dropColumn('payment_lifecycle_id');
            $table->dropColumn('payment_reference');
            $table->dropColumn('context_type');
            $table->dropColumn('payee');
            $table->dropColumn('payer');
            $table->dropColumn('tracing_id');
        });
    }
}

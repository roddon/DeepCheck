<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTinkAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tink_accounts', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('account_number')->nullable();
            $table->float('available_credit')->nullable();
            $table->float('balance')->nullable();
            $table->string('bank_id')->nullable();
            $table->string('certain_date')->nullable();
            $table->string('credentials_id', 50)->nullable();
            $table->string('tink_account_id', 50)->nullable();
            $table->string('name')->nullable();
            $table->string('type', 10)->nullable();
            $table->string('user_id', 50)->nullable();
            $table->string('user_modified_name')->nullable();
            $table->string('identifiers')->nullable();
            $table->string('image_icon')->nullable();
            $table->string('image_banner')->nullable();
            $table->string('holder_name')->nullable();
            $table->string('currency_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tink_accounts');
    }
}

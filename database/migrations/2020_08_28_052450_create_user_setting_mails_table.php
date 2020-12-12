<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_setting_mails', function (Blueprint $table) {
            $table->id();
            $table->text('onboarding_content')->nullable();
            $table->text('check_the_invoice_content')->nullable();
            $table->text('supplier_verification_content')->nullable();
            $table->text('existing_supplier_content')->nullable();
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
        Schema::dropIfExists('user_setting_mails');
    }
}

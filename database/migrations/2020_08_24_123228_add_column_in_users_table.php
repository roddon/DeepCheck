<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('sftp_token')->nullable();
            $table->string('sftp_un')->nullable();
            $table->string('sftp_pw')->nullable();
            $table->string('sftp_server_ip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sftp_token');
            $table->dropColumn('sftp_un');
            $table->dropColumn('sftp_pw');
            $table->dropColumn('sftp_server_ip');
        });
    }
}

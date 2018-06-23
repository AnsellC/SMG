<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddOptionalEtcToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('showfullname')->default(0);
            $table->boolean('email_alerts')->default(1);
            $table->boolean('show_location')->default(1);
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
            $table->dropColumn('showfullname');
            $table->dropColumn('email_alerts');
            $table->dropColumn('show_location');
        });
    }
}

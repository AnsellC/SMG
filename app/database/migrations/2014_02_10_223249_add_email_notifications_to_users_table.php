<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailNotificationsToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->boolean('email_notification_comment')->default(1);
			$table->boolean('email_notification_pm')->default(1);
			$table->boolean('email_notification_like')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('email_notification_like');
			$table->dropColumn('email_notification_pm');
			$table->dropColumn('email_notification_comment');	
		});
	}

}
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserProfilePic extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->mediumtext('profile_picture_s3key')->nullable();
			$table->string('profile_picture_ext', 5)->nullable();
			$table->string('profile_picture_filename', 80)->nullable();
			$table->integer('profile_picture_size')->nullable();
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
			$table->dropColumn('profile_picture_s3key');
			$table->dropColumn('profile_picture_ext');
			$table->dropColumn('profile_picture_filename');
			$table->dropColumn('profile_picture_size');
		});
	}

}
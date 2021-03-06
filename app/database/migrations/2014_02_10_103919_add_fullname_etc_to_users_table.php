<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFullnameEtcToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('fullname')->nullable();
			$table->string('country')->nullable();
			$table->enum('specialty', array('Armor','Aircraft','Warships','Diorama','Landscapes','Railroad','Automotive','Sci-Fi Miniatures','Wargaming','Toy Modeling'))->nullable();
		
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
			$table->dropColumn('fullname');
			$table->dropColumn('country');
			$table->dropColumn('specialty');
		});
	}

}
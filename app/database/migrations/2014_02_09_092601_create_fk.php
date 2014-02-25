<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFk extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('albums', function(Blueprint $table) {
			$table->foreign('userid')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('cover_photoid')->unsigned()->references('id')->on('photos')->onDelete('set null')->onUpdate('set null');	
			//foreign keys
		
		});
		Schema::table('photos', function(Blueprint $table) {
			$table->foreign('userid')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('albumid')->references('id')->on('albums')->onDelete('cascade')->onUpdate('cascade');				
		});		
	
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('albums', function(Blueprint $table){
		
			$table->dropForeign('albums_userid_foreign');
			$table->dropForeign('albums_cover_photoid_foreign');
		});
		Schema::table('photos', function(Blueprint $table){
		
			$table->dropForeign('photos_userid_foreign');
			$table->dropForeign('photos_albumid_foreign');
		});		
		
	}

}

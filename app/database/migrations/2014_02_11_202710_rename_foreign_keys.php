<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RenameForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->renameColumn('userid', 'user_id');
            $table->renameColumn('cover_photoid', 'photo_id');
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->renameColumn('userid', 'user_id');
            $table->renameColumn('albumid', 'album_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

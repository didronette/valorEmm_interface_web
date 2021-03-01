<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoIncidents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table->increments('id');
        $table->integer('incident');
        $table->binary('photo');

        $table->foreign('incident')
				  ->references('id')
				  ->on('Incident')
				  ->onDelete('restrict') // à voir
                  ->onUpdate('restrict');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PhotoIncident', function(Blueprint $table) {
			$table->dropForeign('posts_user_id_foreign');
		});
		Schema::drop('PhotoIncident');
    }
}

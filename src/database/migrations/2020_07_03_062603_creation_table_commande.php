<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreationTableCommande extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table->increments('id');
        $table->integer('numero');
        $table->integer('numero_groupe');
        $table->integer('multiplicite');
        $table->datetime('date_commande');
        $table->datetime('date_enlevement');
        $table->string('nc');
        $table->string('ncagglo');
        $table->string('statut');

        $table->foreign('dechetterie')
				  ->references('id')
				  ->on('Dechetterie')
				  ->onDelete('restrict') // à voir
                  ->onUpdate('restrict');
                  
        $table->foreign('flux')
				  ->references('id')
				  ->on('Flux')
				  ->onDelete('restrict') // à voir
                  ->onUpdate('restrict');
                  
        $table->foreign('compte')
				  ->references('id')
				  ->on('users')
				  ->onDelete('restrict') // à voir
                  ->onUpdate('restrict');
                  
        $table->timestamps();
        $table->timestamp('contact_at', 0);

        $table->string('todo');
 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Commande', function(Blueprint $table) {
			$table->dropForeign('posts_user_id_foreign');
		});
		Schema::drop('Commande');
    }
}

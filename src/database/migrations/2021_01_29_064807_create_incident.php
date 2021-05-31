<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncident extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table->increments('id');
        $table->string('categorie');
        $table->timestamp('date_heure');
        $table->string('immatriculation_vehicule');
        $table->string('type_vehicule');
        $table->string('marque_vehicule');
        $table->string('couleur_vehicule');
        $table->integer('numero_sidem_pass');
        $table->string('description');
        $table->string('reponse_apportee');
        $table->integer('agent');
        $table->integer('dechetterie');
        $table->timestamps();

        $table->foreign('dechetterie')
				  ->references('id')
				  ->on('Dechetterie')
				  ->onDelete('restrict') // à voir
                  ->onUpdate('restrict');

                  
        $table->foreign('agent')
				  ->references('id')
				  ->on('users')
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
        Schema::drop('Incident');
    }
}

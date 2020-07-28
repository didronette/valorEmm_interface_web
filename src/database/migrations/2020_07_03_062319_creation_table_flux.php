<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreationTableFlux extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table->increments('id');
        $table->string('societe');
        $table->string('type');
        $table->string('type_contact');
        $table->string('contact');
        $table->integer('poids_moyen_benne');
        $table->integer('delai_enlevement');
        $table->time('horaires_commande_matin');
        $table->time('horaires_commande_aprem');
        $table->string('jour_commande');
        $table->string('categorie');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Flux');
    }
}

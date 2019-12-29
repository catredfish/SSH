<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListeAttentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liste_attentes', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('idAtelierListeAttentes');
          $table->unsignedInteger('idCompteListeAttentes');
          $table->foreign('idAtelierListeAttentes','idCompteListeAttentes')
          ->references('id','id')
          ->on('Ateliers','Comptes')
          ->onDelete('cascade','cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liste_attentes');
    }
}

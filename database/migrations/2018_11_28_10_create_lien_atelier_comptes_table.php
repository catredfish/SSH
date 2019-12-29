<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienAtelierComptesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lien_atelier_comptes', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('idAtelierLienAtelierCompte');
          $table->unsignedInteger('idCompteLienAtelierCompte');
          $table->foreign('idAtelierLienAtelierCompte', 'idCompteLienAtelierCompte')
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
        Schema::dropIfExists('lien_atelier_comptes');
    }
}

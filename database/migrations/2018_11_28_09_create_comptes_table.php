<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComptesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comptes', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('NumeroIdentification')->nullable();
          $table->string('Nom');
          $table->string('Prenom');
          $table->string('Courriel');
          $table->string('MotDePasse');
          $table->boolean('Actif');

          $table->unsignedInteger('idTypeConnexion');
          $table->foreign('idTypeConnexion')
          ->references('id')
          ->on('Type_De_Connexions')
          ->onDelete('cascade');

          $table->unsignedInteger('idTypeCompte');
          $table->foreign('idTypeCompte')
          ->references('id')
          ->on('Type_De_Comptes')
          ->onDelete('cascade');

          $table->unsignedInteger('idProgramme')->nullable();
          $table->foreign('idProgramme')
          ->references('id')
          ->on('programmes')
          ->onDelete('cascade');
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
        Schema::dropIfExists('comptes');
    }
}

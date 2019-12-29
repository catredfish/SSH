<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAteliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ateliers', function (Blueprint $table) {
          $table->increments('id');
          $table->string('Nom');
          $table->string('Endroit');
          $table->string('HeureDebut');
          $table->string('Duree');
          $table->string('Description', 10000)->nullable();
          $table->date('DateAtelier');
          $table->integer('NombreDePlace');
          $table->unsignedInteger('idCampus');
          $table->unsignedInteger('idProgramme');
          $table->foreign('idCampus','idProgramme')
          ->references('id','id')
          ->on('Campuses','Programmes')
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
        Schema::dropIfExists('ateliers');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienAtelierAnimateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lien_atelier_animateurs', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('idAtelierLienAtelierAnimateur');
          $table->unsignedInteger('idAnimateurLienAtelierAnimateur');
          $table->foreign('idAtelierLienAtelierAnimateur','idAnimateurLienAtelierAnimateur')
          ->references('id','id')
          ->on('Ateliers','Animateurs')
          ->onDelete('cascade','cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lien_atelier_animateurs');
    }
}

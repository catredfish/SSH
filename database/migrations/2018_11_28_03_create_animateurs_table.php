<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animateurs', function (Blueprint $table) {
          $table->increments('id');
          $table->string('Nom');
          $table->string('Prenom');
          $table->string('Biographie', 8000);
          $table->string('Photo');
          $table->string('Courriel');
          $table->string('Expertise');
          $table->boolean('Actif');
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
        Schema::dropIfExists('animateurs');
    }
}

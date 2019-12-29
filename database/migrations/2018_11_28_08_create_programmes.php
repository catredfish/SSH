<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programmes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nom');
            $table->unsignedInteger('idTypeProgramme');
            $table->unsignedInteger('idCategoriesProgramme');
            $table->foreign('idTypeProgramme','idCategoriesProgramme')
            ->references('id','id')
            ->on('types_programme','categories_programme')
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
        Schema::dropIfExists('programmes');
    }
}

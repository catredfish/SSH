<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;
use App\compte;

class VoirEnvoyerRappelViewModel {

    //Propriété
    private $model;

    //Constructeur
    public function __construct() {        
        $this -> model = DB::table("ateliers")->get();
    }

    //Fonction permettant de retourner une liste d'ateliers
    public function getListeAteliers(){
        return $this->model;
    }
}

<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;
use App\compte;

class VoirOublieMotDePasse {

    //Propriété
    private $listeCourriels;

    //Constructeur
    public function __construct() {        
        $this -> listeCourriels = DB::table(Constantes::$TABLE_COMPTES)->pluck(Constantes::$COLUMN_COURRIEL_COMPTE);
    }

    //Fonction permettant de retourner une liste d'ateliers
    public function getListeCourriels(){
        return $this->listeCourriels;
    }
}

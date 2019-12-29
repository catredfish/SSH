<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;
use App\compte;

class VoirCreerAtelierViewModel {

    //Propriété
    private $listeConferenciers;

    //Constructeur
    public function __construct() {
        //Initialise la liste de conférenciers
        $this->listeConferenciers = DB::table(Constantes::$TABLE_ANIMATEURS)->get();
    }

    //Fonction permettant de retourner une liste de conférencier
    public function getListeConferenciers(){
        return $this->listeConferenciers;
    }
}

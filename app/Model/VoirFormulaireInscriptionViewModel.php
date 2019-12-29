<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;
use App\compte;

class VoirFormulaireInscriptionViewModel {

    //Propriété
    private $listeProgrammesTechniques = array();
    private $listeProgrammesPreuniversitaires = array();
    private $tremplinDec;
    private $typeConnexion = "";

    public function getListeProgrammesTechniques(){
        return $this->listeProgrammesTechniques;
    }

    public function getListeProgrammesPreuniversitaires(){
        return $this->listeProgrammesPreuniversitaires;
    }
    
    public function getTremplinDec(){
        return $this->tremplinDec;
    }

    public function getTypeConnexion(){
      return $this->typeConnexion;
    }

    //Constructeur
    public function __construct($idTypeConnexion) {
      //Initialise les listes de programmes
        $this ->listeProgrammesTechniques = DB::table(Constantes::$TABLE_PROGRAMME)->where(Constantes::$COLUMN_ID_TYPE_PROGRAMME,'=',1)->orderby(Constantes::$COLUMN_NOM_PROGRAMME,'asc')->get();
        $this ->listeProgrammesPreuniversitaires = DB::table(Constantes::$TABLE_PROGRAMME)->where(Constantes::$COLUMN_ID_TYPE_PROGRAMME,'=',2)->orderby(Constantes::$COLUMN_NOM_PROGRAMME,'asc')->get();
      //Trouve le type de connexion
      $this->typeConnexion = DB::table(Constantes:: $TABLE_TYPE_DE_CONNEXIONS)->where(Constantes::$COLUMN_ID_TYPE_DE_CONNEXIONS,'=',$idTypeConnexion)->get()[0];
      
      //Trouve le templin dec
      $this->tremplinDec = DB::table(Constantes::$TABLE_PROGRAMME)->where('id','=',31)->get()[0];
    }


}

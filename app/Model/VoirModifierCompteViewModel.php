<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;
use App\compte;

class VoirModifierCompteViewModel {

    //Propriété
    private $compte;
    private $listeProgrammesTechniques = array();
    private $listeProgrammesPreuniversitaires = array();
    private $tremplinDec;
    private $typeProgramme;
    //Constructeur
    public function __construct($Id) {
        $this ->compte = DB::table("comptes")->where('id', '=', $Id)->get()[0];

        //Initialise les listes de programmes
        $this ->listeProgrammesTechniques = DB::table(Constantes::$TABLE_PROGRAMME)->where(Constantes::$COLUMN_ID_TYPE_PROGRAMME,'=',1)->orderby(Constantes::$COLUMN_NOM_PROGRAMME,'asc')->get();
        $this ->listeProgrammesPreuniversitaires = DB::table(Constantes::$TABLE_PROGRAMME)->where(Constantes::$COLUMN_ID_TYPE_PROGRAMME,'=',2)->orderby(Constantes::$COLUMN_NOM_PROGRAMME,'asc')->get();

        //Si le compte est de type visiteur
        if(!is_null($this->compte->idProgramme)){
          $this->typeProgramme = DB::table(Constantes::$TABLE_PROGRAMME)->where('id', '=', $this->compte->idProgramme)->get()[0];
        }
        
        //Trouve le templin dec
      $this->tremplinDec = DB::table(Constantes::$TABLE_PROGRAMME)->where('id','=',31)->get()[0];
    }

    public function getCompte(){
      return $this->compte;
    }

    public function getTypeDeProgramme(){
      return $this->typeProgramme;
    }

    public function getListeProgrammesTechniques(){
        return $this->listeProgrammesTechniques;
    }

    public function getListeProgrammesPreuniversitaires(){
        return $this->listeProgrammesPreuniversitaires;
    }
    
    public function getTremplinDec(){
        return $this->tremplinDec;
    }
}

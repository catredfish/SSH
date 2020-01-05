<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;

class VoirReinitialisationOublieMotDePasseViewModel {

    //Propriétés
    private $Courriel;
    private $Jeton;

    //Constructeur
    public function __construct(string $param_courriel, string $param_jeton) { 
        $this ->Courriel = $param_courriel;
        $this ->Jeton = $param_jeton;
        
    }
    
    public function getCourriel(){
        return $this->Courriel;
    }
    
    public function getJeton(){
        return $this->Jeton;
    }
}

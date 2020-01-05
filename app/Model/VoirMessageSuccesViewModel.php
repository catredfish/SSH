<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;

class VoirMessageSuccesViewModel {

    //Propriétés
    private $titre;
    private $message;  
    private $retourAccueil;

    //Constructeur
    public function __construct($param_titre = null, $param_message = null, $param_retour_accueil = null) { 
        //assigne les valeurs pour la modale de succès
        $this ->titre = $param_titre??Constantes::$TITRE_DEFAUT_ERREUR;
        $this ->message = $param_message??Constantes::$MESSAGE_DEFAUT_ERREUR;
        $this ->retourAccueil = $param_retour_accueil??false;
    }
    
    public function getTitre(){
        return $this->titre;
    }
    
    public function getMessage(){
        return $this->message;
    }
    
    public function getRetourAccueil(){
        return $this->retourAccueil;
    }
    
}

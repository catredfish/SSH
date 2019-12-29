<?php

namespace App\Model;

class VoirMessageErreurViewModel {

    //Propriétés
    private $titre = "";
    private $message = "";

    //Constructeur
    public function __construct($paramTitre, $paramMessage) {
        $this->titre = $paramTitre;
        $this->message = $paramMessage;
    }

    //Accesseurs
    public function getMessage() {
        return $this->message;
    }
    public function getTitre() {
        return $this->titre;
    }
}

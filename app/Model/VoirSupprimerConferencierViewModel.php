<?php
/**
 * Created by PhpStorm.
 * User: Thulium_Selenium
 * Date: 2019-02-05
 * Time: 7:57 PM
 */

namespace App\Model;

use App\Constantes;
use Illuminate\Support\Facades\DB;

class VoirSupprimerConferencierViewModel
{
    //Propriété
    private $nom;
    private $prenom;
    private $id;
    private $onglet;
    private $photo;


    //Constructeur
    public function __construct($Id) {

        // Obtient le conférencier
        $this -> model = DB::table(CONSTANTES::$TABLE_CONFERENCIERS)->where(CONSTANTES::$COLUMN_ID, '=', $Id)->get();

        //Vérifie si aucun conférencier n'a été trouvé
        if(count($this -> model) == 0){

            //Si tel est le cas, assigne le modèle comme étant null
            $this ->setId(0);
            $this ->setNom("");
            $this ->setPrenom("");
            $this ->setOnglet(1);
            $this ->setPhoto("");
        }

        //Si un conférencier a été trouvé, l'assigne au modèle
        else{
            $this ->setId($this ->model[0]->id);
            $this ->setNom($this ->model[0]->Nom);
            $this ->setPrenom($this ->model[0]->Prenom);
            $this ->setOnglet($this ->model[0]->Actif);
            $this ->setPhoto($this ->model[0]->Photo);
        }
    }

    //Accesseur
    public function getId(){
        return $this->id;
    }
    public function getNom(){
        return $this->nom;
    }
    public function getPrenom(){
        return $this->prenom;
    }
    public function getOnglet(){
        return $this->onglet;
    }
    public function getPhoto(){
        return $this->photo;
    }
    private function setId($valeur){
        $this->id = $valeur;
    }
    private function setNom($valeur){
        $this->nom = $valeur;
    }
    private function setPrenom($valeur){
        $this->prenom = $valeur;
    }
    private function setOnglet($valeur){
        $this->onglet = $valeur;
    }
    private function setPhoto($valeur){
        $this->photo = $valeur;
    }
}
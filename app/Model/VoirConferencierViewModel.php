<?php
/**
 * Created by PhpStorm.
 * User: Thulium_Selenium
 * Date: 2019-02-07
 * Time: 9:20 PM
 */

namespace App\Model;
use App\Constantes;
use Illuminate\Support\Facades\DB;

class VoirConferencierViewModel
{
    //Propriété
    private $nom;
    private $prenom;
    private $id;
    private $biographie;
    private $photo;
    private $expertise;
    private $courriel;

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
            $this ->setBiographie("");
            $this ->setPhoto("");
            $this ->setExpertise("");
            $this ->setCourriel("");
        }

        //Si un conférencier a été trouvé, l'assigne au modèle
        else{
            $this ->setId($this ->model[0]->id);
            $this ->setNom($this ->model[0]->Nom);
            $this ->setPrenom($this ->model[0]->Prenom);
            $this ->setBiographie($this ->model[0]->Biographie);
            $this ->setPhoto($this ->model[0]->Photo);
            $this ->setExpertise($this ->model[0]->Expertise);
            $this ->setCourriel($this ->model[0]->Courriel);
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
    public function getBiographie(){
        return $this->biographie;
    }
    public function getPhoto(){
        return $this->photo;
    }
    public function getExpertise(){
        return $this->expertise;
    }
    public function getCourriel(){
        return $this->courriel;
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
    private function setBiographie($valeur){
        $this->biographie = $valeur;
    }
    private function setPhoto($valeur){
        $this->photo = $valeur;
    }
    private function setExpertise($valeur){
        $this->expertise = $valeur;
    }
    private function setCourriel($valeur){
        $this->courriel = $valeur;
    }
}
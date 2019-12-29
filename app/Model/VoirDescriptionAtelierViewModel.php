<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;
use App\compte;

class VoirDescriptionAtelierViewModel {

    //Propriété
    private $atelier;
    private $listeConferenciers = array();
    private $nombreParticipants = 0;

    //Constructeur
    public function __construct($idAtelier) {
        //Trouve l'atelier correspondant
        $this->atelier = DB::table("ateliers")->where('id','=',$idAtelier)->get()[0];

        //Initialise la liste des lien_atelier_animateurs
        $listeLienAtelierAniomateur = DB::table(Constantes::$TABLE_LIEN_ATELIER_ANIMATEURS)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_ANIMATEUR,'=',$idAtelier)->get();

        //Initialise la liste des conférenciers sélectionnés
        foreach ($listeLienAtelierAniomateur as $lienAtelierAnimateur) {
          //Pour chaque lien qui contient le numéro de l'atelier, extrait le numéro du conférencier et trouve le conférencier correspondant dans la table animateurs
          $conferencier = DB::Table(Constantes::$TABLE_ANIMATEURS)->where(Constantes::$COLUMN_ID,'=',$lienAtelierAnimateur->idAnimateurLienAtelierAnimateur)->get()[0];

          //Ajoute le conférencier à la liste des conférienciers sélectionnés
          $this->listeConferenciers[] = $conferencier;
        }

        //Ajoute le nombre de participants
        $this->nombreParticipants = count(DB::TABLE(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $this->atelier->id)->get());
    }
    //Fonction permettant de retourner une liste d'ateliers
    public function getAtelier(){
        return $this->atelier;
    }
    public function getListeConferenciers(){
      return $this->listeConferenciers;
    }
    public function getNombreParticipants(){
        return $this->nombreParticipants;
    }
  }

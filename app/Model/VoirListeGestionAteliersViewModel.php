<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;
use DateTime;

class VoirListeGestionAteliersViewModel {

    //Propriétés
    private $campusSelectionne = 1;
    private $ongletSelectionne = 1;
    private $listeAteliers = array();
    private $listeCampus = array();
    private $dateSelectionnee = "";

    //Constructeur
    public function __construct() {
    }

    //Accesseurs
    public function getNumeroCampus() {
        return $this->campusSelectionne;
    }
    public function getOngletSelectionne() {
        return $this->ongletSelectionne;
    }
    public function getDateSelectionnee() {
        return $this->dateSelectionnee;
    }
    public function getListeAteliers() {
        return $this->listeAteliers;
    }
    public function getListeCampus() {
        return $this->listeCampus;
    }

    //Fonction permettant d'assigner des valeurs aux propriétés du modèle
    public function GenererListe($numeroCampus, $paramDateSelectionnee, $numeroOngletSelectionne) {
        //Met à jour le campus sélectionné
        if(isset($numeroCampus)){
          $this->campusSelectionne = $numeroCampus;
        }
        //Met à jour l'onglet sélectionnée
        if(isset($numeroOngletSelectionne)){
          $this->ongletSelectionne = $numeroOngletSelectionne;
        }
        //Initialise la liste de campus
        $this->listeCampus = DB::table(Constantes::$TABLE_CAMPUSES)->get();

        //Essaie de convertir la date dans un format valide
        $date = DateTime::createFromFormat('Y-m-d', $paramDateSelectionnee);

        //Vérifie si la conversion a réussie
        if ($date != false) {

            //Si tel est le cas, met à jour la date sélectionnée
            $this->dateSelectionnee = $paramDateSelectionnee;

            //Change le format de la date pour celui utilisé dans la base de données
            $dateTime = new DateTime($paramDateSelectionnee);
            $date = $dateTime->format('Y-m-d H:i:s');
        }

        //Initialise la liste des ateliers et si le numéro de campus est égal à 1, sélectionne tous les ateliers
        if ($this->campusSelectionne == 1) {

            //Vérifie si la date est valide
            if ($date != false) {

                //Si tel est le cas, obtient les ateliers qui sont associés à cette date
                $this->listeAteliers = DB::table(Constantes::$TABLE_ATELIERS)->where('DateAtelier', '=', $date)->get();
            }

            //Sinon, obtient tous les ateliers
            else{

                //Obtient tous les ateliers
                $this->listeAteliers = DB::table(Constantes::$TABLE_ATELIERS)->get();
            }
        }

        //Sinon, sélectionne les ateliers avec le numéro de campus correspondant
        else {

            //Vérifie si la date est valide
            if ($date != false) {

                //Si tel est le cas, obtient les ateliers qui sont associés à cette date et à ce campus
                $this->listeAteliers = DB::table(Constantes::$TABLE_ATELIERS)->where([['idCampus', '=', (int) $numeroCampus], ['DateAtelier', '=', $date]])->get();
            }

            //Sinon, obtient tous les ateliers associés au campus
            else{

                //Obtient tous les ateliers associés au campus
                $this->listeAteliers = DB::table(Constantes::$TABLE_ATELIERS)->where('idCampus', '=', (int) $numeroCampus)->get();
            }
        }

        //Ajoute le nombre de participants actuel pour chaque atelier de la liste des atelier disponibles, listeAteliersUtilisateurInscrit, $listeAteliersEnConflit, $listeAteliersPleineCapacite
        foreach ($this->listeAteliers as $atelier) {
          $atelier->NombreDeParticipants = count(DB::TABLE(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $atelier->id)->get());
        }
    }
}

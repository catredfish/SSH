<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;

class VoirListeConferenciersViewModel {

    //Propriétés
    private $listeConferenciersInactifs = array();
    private $listeConferenciersActifs = array();
    private $ongletSelectionne = 1;

    //Constructeur
    public function __construct() {
    }

    //Accesseurs
    public function getListeConferenciersActifs() {
        return $this->listeConferenciersActifs;
    }

    public function getListeConferenciersInactifs() {
        return $this->listeConferenciersInactifs;
    }
    public function getOngletSelectionne() {
        return $this->ongletSelectionne;
    }
    public function setOngletSelectionne($valeur) {
        return $this->ongletSelectionne = $valeur;
    }

    public function GenererListe($estAdministrateur) {

        // Si l'utilisateur est un administrateur, montre tous les conférenciers
        if($estAdministrateur){
            $conferenciersActifs = DB::table(Constantes::$TABLE_CONFERENCIERS)->where(Constantes::$COLUMN_ACTIF, '=', 1)->get();
            $conferenciersInactifs = DB::table(Constantes::$TABLE_CONFERENCIERS)->where(Constantes::$COLUMN_ACTIF, '=', 0)->get();

            //Pour chaque conferencier actif
            foreach ($conferenciersActifs as $conferencier) {

                //Ajoute chaque conférenciers à la liste
                $this->listeConferenciersActifs[] =  $conferencier;
            }

            //Pour chaque conférencier inactif
            foreach ($conferenciersInactifs as $conferencier) {

                //Ajoute chaque conférenciers à la liste
                $this->listeConferenciersInactifs[] =  $conferencier;
            }
        }

        // Sinon, cache ceux inactifs
        else{
            $conferenciers = DB::table(Constantes::$TABLE_CONFERENCIERS)->where(Constantes::$COLUMN_ACTIF, '=', 1)->get();

            //Pour chaque ligne de la table conferenciers
            foreach ($conferenciers as $conferencier) {

                //Ajoute chaque conférenciers à la liste
                $this->listeConferenciersActifs[] = $conferencier;
            }
        }
    }
}

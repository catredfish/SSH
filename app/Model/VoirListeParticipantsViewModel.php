<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;
use DateTime;

class VoirListeParticipantsViewModel {

    //Propriétés
    private $listeParticipants = array();
    private $atelier;
    //Constructeur
    public function __construct() {
    }

    //Accesseurs
    public function getListeParticipants() {
        return $this->listeParticipants;
    }

    public function getAtelier(){
      return $this->atelier;
    }

    public function GenererListe($numeroAtelierSelectionne) {
      //Trouve l'Atelier sélectionné dans la base de données.
      $this->atelier = DB::table(Constantes::$TABLE_ATELIERS)->where(Constantes::$COLUMN_ID, '=',$numeroAtelierSelectionne)->get()[0];

      //Pour chaque ligne de la table lien_atelier_comptes où le numéro de l'atelier correspond à celui passé en paramètre
      $inscriptions = DB::table(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', (int)$numeroAtelierSelectionne)->get();
      foreach ($inscriptions as $inscription) {
        //Trouve le compte possédant le numéro contenu dans cette inscription
        $compte = DB::table(Constantes::$TABLE_COMPTES)->where(Constantes::$COLUMN_ID, '=', $inscription->idCompteLienAtelierCompte)->get();
        //Ajoute ce compte à la liste des participants
        $this->listeParticipants[] = $compte[0];

      }
    }
}

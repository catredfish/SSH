<?php
/**
 * Created by PhpStorm.
 * User: Thulium_Selenium
 * Date: 2019-02-11
 * Time: 7:48 PM
 */

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;

class VoirListeAdministrateursViewModel
{
    //Propriétés
    private $listeComptesEleves = array();
    private $listeComptesEmployes = array();
    private $listeComptesVisiteurs = array();
    private $ongletSelectionne = 1;

    //Constructeur
    public function __construct() {
    }

    //Accesseurs
    public function getListeComptesEleves() {
        return $this->listeComptesEleves;
    }
    public function getListeComptesEmployes() {
        return $this->listeComptesEmployes;
    }
    public function getListeComptesVisiteurs() {
        return $this->listeComptesVisiteurs;
    }
    public function getOngletSelectionne() {
        return $this->ongletSelectionne;
    }
    public function setOngletSelectionne($valeur) {
        return $this->ongletSelectionne = $valeur;
    }

    public function GenererListe() {

        // Obtient tous les comptes
        $comptesEleves = DB::table(Constantes::$TABLE_COMPTES)->where([[Constantes::$COLUMN_ID_TYPE_DE_CONNEXION, '=', Constantes::$ID_ELEVE],
            [Constantes::$COLUMN_TYPE_DE_COMPTE, '!=', Constantes::$ID_SUPER_ADMINISTRATEUR]])->get();
        $comptesEmployes = DB::table(Constantes::$TABLE_COMPTES)->where([[Constantes::$COLUMN_ID_TYPE_DE_CONNEXION, '=', Constantes::$ID_EMPLOYE],
            [Constantes::$COLUMN_TYPE_DE_COMPTE, '!=', Constantes::$ID_SUPER_ADMINISTRATEUR]])->get();
        $comptesVisiteurs = DB::table(Constantes::$TABLE_COMPTES)->where([[Constantes::$COLUMN_ID_TYPE_DE_CONNEXION, '=', Constantes::$ID_VISITEUR],
            [Constantes::$COLUMN_TYPE_DE_COMPTE, '!=', Constantes::$ID_SUPER_ADMINISTRATEUR]])->get();

        //Pour chaque compte d'élève
        foreach ($comptesEleves as $eleve) {

            //Ajoute chaque élève à la liste
            $this->listeComptesEleves[] =  $eleve;
        }

        //Pour chaque compte d'employé
        foreach ($comptesEmployes as $employe) {

            //Ajoute chaque employé à la liste
            $this->listeComptesEmployes[] =  $employe;
        }

        //Pour chaque compte de visiteur
        foreach ($comptesVisiteurs as $visiteur) {

            //Ajoute chaque visiteur à la liste
            $this->listeComptesVisiteurs[] =  $visiteur;
        }
    }
}
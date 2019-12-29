<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\Constantes;
use DateTime;

class VoirListeAteliersViewModel {

    //Propriétés
    private $campusSelectionne = 1;
    private $ongletSelectionne = 1;
    private $dateSelectionnee = "";
    private $listeAteliersUtilisateurInscrit = array();
    private $listeAteliersDisponibles = array();
    private $listeAteliersPleineCapacite = array();
    private $listeCampus = array();
    private $listeAttentes = array();
    private $listeAteliersEnConflit = array();
    private $listeMessagesAteliersEnConflit;

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
    public function getListeAteliersUtilisateurInscrit() {
        return $this->listeAteliersUtilisateurInscrit;
    }
    public function getListeAttentes() {
        return $this->listeAttentes;
    }
    public function getListeAteliersDisponibles() {
        return $this->listeAteliersDisponibles;
    }
    public function getListeAtelierPleineCapacite() {
        return $this->listeAteliersPleineCapacite;
    }
    public function getListeCampus() {
        return $this->listeCampus;
    }
    public function getListeAteliersEnConflit() {
        return $this->listeAteliersEnConflit;
    }
    public function getListeMessagesAteliersEnConflit() {
        return $this->listeMessagesAteliersEnConflit;
    }

    //Fonction permettant d'assigner des valeurs aux propriétés du modèle
    public function GenererListe($numeroCampus, $numeroUtilisateur, $paramOngletSelectionnee, $paramDateSelectionnee) {

        //Met à jour l'onglet sélectionné
        $this->ongletSelectionne = $paramOngletSelectionnee;

        //Met à jour le campus sélectionné
        $this->campusSelectionne = $numeroCampus;

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


        //Initialise la liste d'ateliers disponibles et si le numro de campus est égal à 1, sélectionne tous les ateliers qui ne sont pas à pleine capacité
        if ((int) $numeroCampus == 1) {
            //Vérifie si la date est valide
            if ($date != false) {
                //Initialise la liste de tous les ateliers où la date correspond
                $listeTousAteliers = DB::table(Constantes::$TABLE_ATELIERS)->where('DateAtelier', '=', $date)->get();

                //Pour chacun de ces ateliers
                foreach ($listeTousAteliers as $atelier) {
                  //Si le nombre de place est supérieur au nombre de participants, l'atelier est disponbile et l'ajoute à la liste d'ateliers disponibles.
                  if($atelier->NombreDePlace > count(DB::TABLE(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $atelier->id)->get())){
                    $this->listeAteliersDisponibles[] = $atelier;
                  }
                  else{
                    //Sinon, l'atelier est à pleine capacité et l'ajoute dans la liste des ateliers à pleine capacité
                    $this->listeAteliersPleineCapacite[] = $atelier;
                  }
                }
            }

            //Sinon, ne prend pas en considération la date
            else {
                //Initialise la liste de tous les ateliers où la date correspond
                $listeTousAteliers = DB::table(Constantes::$TABLE_ATELIERS)->get();

                //Pour chacun de ces ateliers
                foreach ($listeTousAteliers as $atelier) {
                  //Si le nombre de place est supérieur au nombre de participants, l'atelier est disponbile et l'ajoute à la liste d'ateliers disponibles.
                  if($atelier->NombreDePlace > count(DB::TABLE(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $atelier->id)->get())){
                    $this->listeAteliersDisponibles[] = $atelier;
                  }
                  else{
                    //Sinon, l'atelier est à pleine capacité et l'ajoute dans la liste des ateliers à pleine capacité
                    $this->listeAteliersPleineCapacite[] = $atelier;
                  }
                }
            }
        }

        //Sinon, sélectionne les ateliers avec le numéro de campus correspondant
        else {

            //Si la date est valide
            if ($date != false) {

                //Initialise la liste de tous les ateliers où la date correspond et où le campus correspond
                $listeTousAteliers = DB::table(Constantes::$TABLE_ATELIERS)->where([['idCampus', '=', (int) $numeroCampus], ['DateAtelier', '=', $date]])->get();

                //Pour chacun de ces ateliers
                foreach ($listeTousAteliers as $atelier) {
                  //Si le nombre de place est supérieur au nombre de participants, l'atelier est disponbile et l'ajoute à la liste d'ateliers disponibles.
                  if($atelier->NombreDePlace > count(DB::TABLE(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $atelier->id)->get())){
                    $this->listeAteliersDisponibles[] = $atelier;
                  }
                  else{
                    //Sinon, l'atelier est à pleine capacité et l'ajoute dans la liste des ateliers à pleine capacité
                    $this->listeAteliersPleineCapacite[] = $atelier;
                  }
                }
            }

            //Sinon, ne prend pas en considération la date
            else {
                //Initialise la liste de tous les ateliers où le campus correspond
                $listeTousAteliers = DB::table(Constantes::$TABLE_ATELIERS)->where('idCampus', '=', (int) $numeroCampus)->get();

                //Pour chacun de ces ateliers
                foreach ($listeTousAteliers as $atelier) {
                  //Si le nombre de place est supérieur au nombre de participants, l'atelier est disponbile et l'ajoute à la liste d'ateliers disponibles.
                  if($atelier->NombreDePlace > count(DB::TABLE(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $atelier->id)->get())){
                    $this->listeAteliersDisponibles[] = $atelier;
                  }
                  else{
                    //Sinon, l'atelier est à pleine capacité et l'ajoute dans la liste des ateliers à pleine capacité
                    $this->listeAteliersPleineCapacite[] = $atelier;
                  }
                }
            }
        }

        //Initialise la liste de liens atelier-compte où l'utilisateur est inscrit
        $ListeLiensAteliersInscrit = DB::table(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where(Constantes::$COLUMN_ID_COMPTE_LIEN_ATELIER_COMPTE, '=', (int) $numeroUtilisateur)->get();

        //Pour chaque éléments de cette liste, ajoute l'atelier correspondant à la liste d'atelier où l'utilisateur est inscrit et le retire de la liste des ateliers disponibles
        foreach ($ListeLiensAteliersInscrit as $lien) {
            //Vérifie si la date est valide
            if ($date != false) {

                //Si tel est le cas, trouve l'atelier qui a le même numéro que celui dans le lien et la même date
                $atelierInscrit = DB::table(Constantes::$TABLE_ATELIERS)->where([['id', '=', (int) $lien->idAtelierLienAtelierCompte], ['DateAtelier', '=', $date]])->get();
            }

            //Sinon, ignore la date
            else {

                //Trouve l'atelier qui a le même numéro que celui dans le lien
                $atelierInscrit = DB::table(Constantes::$TABLE_ATELIERS)->where('id', '=', (int) $lien->idAtelierLienAtelierCompte)->get();
            }

            //Si un atelier avec la date correspondante a été trouvé.
            if(count($atelierInscrit) != 0){
              //Vérifie si le numéro de campus de l'atelier est égal à celui de la fonction ou bien si le numéro de campus est égal à 1
              if ($atelierInscrit[0]->idCampus == $numeroCampus || $numeroCampus == 1) {

                  //Ajoute cet atelier à la liste d'ateliers où l'utilisateur est inscrit
                  $this->listeAteliersUtilisateurInscrit[] = $atelierInscrit[0];
              }

              //Vérifie si l'atelier inscrit trouvé est présent dans la liste des ateliers disponibles
              $index;
              if (($index = array_search($atelierInscrit[0], $this->listeAteliersDisponibles)) !== false) {

                  //Si tel est le cas, retire cet atelier de la liste d'ateliers disponibles
                  unset($this->listeAteliersDisponibles[$index]);
              }

              //Vérifie si l'atelier inscrit trouvé est présent dans la liste des ateliers à pleine capacité
              if (($index = array_search($atelierInscrit[0], $this->listeAteliersPleineCapacite)) !== false) {

                  //Si tel est le cas, retire cet atelier de la liste des ateliers à pleine capacité
                  unset($this->listeAteliersPleineCapacite[$index]);
              }
              
              
              //Trouve les ateliers qui ont un conflit d'horaire avec l'atelier où s'est incrit l'utilisateur
              $ateliersEnConflits = array_where($this->listeAteliersDisponibles, function($value, $key) use($atelierInscrit) {
                  return $this->tempsVersMinutes($value->HeureDebut) + $this->tempsVersMinutes($value->Duree) > $this->tempsVersMinutes($atelierInscrit[0]->HeureDebut) &&
                  $this->tempsVersMinutes($value->HeureDebut) + $this->tempsVersMinutes($value->Duree) <= $this->tempsVersMinutes($atelierInscrit[0]->HeureDebut) + $this->tempsVersMinutes($atelierInscrit[0]->Duree) && $value->DateAtelier == $atelierInscrit[0]->DateAtelier
                  || $this->tempsVersMinutes($value->HeureDebut) >= $this->tempsVersMinutes($atelierInscrit[0]->HeureDebut) && $this->tempsVersMinutes($value->HeureDebut) < $this->tempsVersMinutes($atelierInscrit[0]->HeureDebut) + $this->tempsVersMinutes($atelierInscrit[0]->Duree) && $value->DateAtelier == $atelierInscrit[0]->DateAtelier;
              });
              $ateliersEnConflits += array_where($this->listeAteliersPleineCapacite, function($value, $key) use($atelierInscrit) {
                  return $this->tempsVersMinutes($value->HeureDebut) + $this->tempsVersMinutes($value->Duree) > $this->tempsVersMinutes($atelierInscrit[0]->HeureDebut) &&
                  $this->tempsVersMinutes($value->HeureDebut) + $this->tempsVersMinutes($value->Duree) <= $this->tempsVersMinutes($atelierInscrit[0]->HeureDebut) + $this->tempsVersMinutes($atelierInscrit[0]->Duree) && $value->DateAtelier == $atelierInscrit[0]->DateAtelier
                  || $this->tempsVersMinutes($value->HeureDebut) >= $this->tempsVersMinutes($atelierInscrit[0]->HeureDebut) && $this->tempsVersMinutes($value->HeureDebut) < $this->tempsVersMinutes($atelierInscrit[0]->HeureDebut) + $this->tempsVersMinutes($atelierInscrit[0]->Duree) && $value->DateAtelier == $atelierInscrit[0]->DateAtelier;
              });


              //Ajoute les ateliers en conflit dans la liste et les retire de la liste d'ateliers disponibles
              foreach ($ateliersEnConflits as $atelierEnConflit) {
                    
                    
                  $atelierEnConflit->messagesConflit[] = "<strong>L'horaire de cet atelier entre en conflit avec l'atelier suivant :</strong><br><br><strong>Nom :</strong> " . $atelierInscrit[0]->Nom . "<br><strong>Heure de début :</strong> " . $atelierInscrit[0]->HeureDebut .
                          "<br><strong>Heure de fin :</strong> " . $this->minutesVersTemps($this->tempsVersMinutes($atelierInscrit[0]->HeureDebut) + $this->tempsVersMinutes($atelierInscrit[0]->Duree)).
                          "<br><strong>Date :</strong> ". $atelierInscrit[0]->DateAtelier;
                          
                  //Ajoute l'atelier à la liste des ateliers en conflit
                  $this->listeAteliersEnConflit[] = $atelierEnConflit;

                  //Si l'élément est trouvé, retire l'atelier de la liste d'ateliers disponibles
                  if (($index = array_search($atelierEnConflit, $this->listeAteliersDisponibles)) !== false) {

                      //Retire cet atelier de la liste d'ateliers disponibles
                      unset($this->listeAteliersDisponibles[$index]);
                  }

                  //Si l'élément est trouvé, retire l'atelier de la des ateliers à pleine capacité
                  if (($index = array_search($atelierEnConflit, $this->listeAteliersPleineCapacite)) !== false) {

                      //Retire cet atelier de la liste d'ateliers disponibles
                      unset($this->listeAteliersPleineCapacite[$index]);
                  }
              }
            }
        }

        //Initialise la liste d'attente pour cet utilisateur
        $ListeAttentesInscrit = DB::table(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->where(Constantes::$COLUMN_ID_COMPTE_LISTE_ATTENTES, '=', $numeroUtilisateur)->get();

        //Pour chaque éléments de cette liste, ajoute l'atelier correspondant à la liste d'atelier où l'utilisateur est inscrit et la retire de la liste des ateliers disponibles
        foreach ($ListeAttentesInscrit as $lien) {

            //Vérifie si la date est valide
            if ($date != false) {

                //Si tel est le cas, trouve l'atelier qui a le même numéro que celui dans le lien et où la date correspond
                $atelierListeAttentes = DB::table(Constantes::$TABLE_ATELIERS)->where([['id', '=', (int) $lien->idAtelierListeAttentes], ['DateAtelier', '=', $date]])->get();
            }

            //Sinon, ignore la date
            else {

                //Si tel est le cas, trouve l'atelier qui a le même numéro que celui dans le lien
                $atelierListeAttentes = DB::table(Constantes::$TABLE_ATELIERS)->where('id', '=', (int) $lien->idAtelierListeAttentes)->get();
            }

            //Vérifie si le numéro de campus de l'atelier est égal à celui de la fonction ou bien si le numéro de campus est égal à 1
            if ($atelierListeAttentes[0]->idCampus == $numeroCampus || $numeroCampus == 1) {

                //Si tel est le cas, ajoute cet atelier à la liste des ateliers en attente
                $this->listeAttentes[] = $atelierListeAttentes[0];
            }

            //Vérifie si l'atelier ayant le même numéro que le lien est présent dans la liste des ateliers en attente
            $index;
            if (($index = array_search($atelierListeAttentes[0], $this->listeAteliersPleineCapacite)) !== false) {

                //Si tel est le cas, retire cet atelier de la liste des ateliers à pleine capacité
                unset($this->listeAteliersPleineCapacite[$index]);
            }

            //Trouve les ateliers qui ont un conflit d'horaire avec l'atelier où s'est incrit l'utilisateur
            $ateliersEnConflits = array_where($this->listeAteliersDisponibles, function($value, $key) use($atelierListeAttentes) {
                return 
                  $this->tempsVersMinutes($value->HeureDebut) + $this->tempsVersMinutes($value->Duree) <= $this->tempsVersMinutes($atelierListeAttentes[0]->HeureDebut) + $this->tempsVersMinutes($atelierListeAttentes[0]->Duree) && $value->DateAtelier == $atelierListeAttentes[0]->DateAtelier
                  || $this->tempsVersMinutes($value->HeureDebut) >= $this->tempsVersMinutes($atelierListeAttentes[0]->HeureDebut) && $this->tempsVersMinutes($value->HeureDebut) < $this->tempsVersMinutes($atelierListeAttentes[0]->HeureDebut) + $this->tempsVersMinutes($atelierListeAttentes[0]->Duree) && $value->DateAtelier == $atelierListeAttentes[0]->DateAtelier;
            });

            $ateliersEnConflits += array_where($this->listeAteliersPleineCapacite, function($value, $key) use($atelierListeAttentes) {
                return 
                  $this->tempsVersMinutes($value->HeureDebut) + $this->tempsVersMinutes($value->Duree) <= $this->tempsVersMinutes($atelierListeAttentes[0]->HeureDebut) + $this->tempsVersMinutes($atelierListeAttentes[0]->Duree) && $value->DateAtelier == $atelierListeAttentes[0]->DateAtelier
                  || $this->tempsVersMinutes($value->HeureDebut) >= $this->tempsVersMinutes($atelierListeAttentes[0]->HeureDebut) && $this->tempsVersMinutes($value->HeureDebut) < $this->tempsVersMinutes($atelierListeAttentes[0]->HeureDebut) + $this->tempsVersMinutes($atelierListeAttentes[0]->Duree) && $value->DateAtelier == $atelierListeAttentes[0]->DateAtelier;
            });

            //Ajoute les ateliers en conflit dans la liste et les retire de la liste d'ateliers disponibles
            foreach ($ateliersEnConflits as $atelierEnConflit) {
				
				/*Ajouté par Samir */
				$atelierEnConflit->messagesConflit[] = "<strong>L'horaire de cet atelier entre en conflit avec l'atelier suivant :</strong><br><br><strong>Nom :</strong> " . $atelierListeAttentes[0]->Nom . "<br><strong>Heure de début :</strong> " . $atelierListeAttentes[0]->HeureDebut .
                          "<br><strong>Heure de fin :</strong> " . $this->minutesVersTemps($this->tempsVersMinutes($atelierListeAttentes[0]->HeureDebut) + $this->tempsVersMinutes($atelierListeAttentes[0]->Duree)).
                          "<br><strong>Date :</strong> ". $atelierListeAttentes[0]->DateAtelier;
                
                /****Modifié par Samir******
				$atelierEnConflit->messagesConflit[] = "<strong>L'horaire de cet atelier entre en conflit avec l'atelier suivant :</strong><br><br><strong>Nom :</strong> " . $atelierInscrit[0]->Nom . "<br><strong>Heure de début :</strong> " . $atelierInscrit[0]->HeureDebut .
                          "<br><strong>Heure de fin :</strong> " . $this->minutesVersTemps($this->tempsVersMinutes($atelierInscrit[0]->HeureDebut) + $this->tempsVersMinutes($atelierInscrit[0]->Duree)).
                          "<br><strong>Date :</strong> ". $atelierInscrit[0]->DateAtelier;*/
                  
                //Ajoute l'atelier à la liste des ateliers en conflit
                $this->listeAteliersEnConflit[] = $atelierEnConflit;

                //Si l'élément est trouvé, retire l'atelier de la liste d'ateliers disponibles
                if (($index = array_search($atelierEnConflit, $this->listeAteliersDisponibles)) !== false) {

                    //Retire cet atelier de la liste d'ateliers disponibles
                    unset($this->listeAteliersDisponibles[$index]);
                }
            }
            
            
        }

        //Ajoute le nombre de participants actuel pour chaque atelier de la liste des atelier disponibles, listeAteliersUtilisateurInscrit, $listeAteliersEnConflit, $listeAteliersPleineCapacite
        foreach ($this->listeAteliersDisponibles as $atelier) {
          $atelier->NombreDeParticipants = count(DB::TABLE(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $atelier->id)->get());
        }
        foreach ($this->listeAteliersUtilisateurInscrit as $atelier) {
          $atelier->NombreDeParticipants = count(DB::TABLE(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $atelier->id)->get());
        }
        foreach ($this->listeAteliersEnConflit as $atelier) {
          $atelier->NombreDeParticipants = count(DB::TABLE(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $atelier->id)->get());
        }

        //Ajoute le nombre de personne de la liste d'attentes au nombre maximal de place pour un atelier à pleine capacité. Cela agira comme un surplus. Exemple : 36/30 veut dire qu'il y a 6 personnes dans la liste d'attentes.
        foreach ($this->listeAteliersPleineCapacite as $atelier) {
          $atelier->NombreDeParticipants = count(DB::TABLE(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->where(Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES, '=', $atelier->id)->get()) + $atelier->NombreDePlace;
        }

        //Détermine la position de l'utilisateur dans chacune des listes d'attentess où il est présent.
        foreach ($this->listeAttentes as $atelier) {
           $listeDeLiens = DB::TABLE(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->where(Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES, '=', $atelier->id)->get();

           $position;
           //Trouve la position
           for($index = 0; $index < count($listeDeLiens); $index++) {
             //Si le numéro de l'utilisateur correspond à celui dans cette ligne, alors l'index de cette ligne correspond à sa position dans la liste d'attentes
             if($listeDeLiens[$index]->idCompteListeAttentes == $numeroUtilisateur){
               $position = $index + 1;
               //Sort de la boucle
               break;
             }
           }

           //Ajoute l'attribut positionListeAttentes à l'atelier
           $atelier->positionListeAttentes = $position;
        }



        //Remet en ordre les indexs de la liste d'ateliers disponibles
        $this->listeAteliersDisponibles = array_values(array_filter($this->listeAteliersDisponibles));

        //Remet en ordre la liste d'attente
        $this->listeAttentes = array_values(array_filter($this->listeAttentes));

        //Remet en ordre la liste des ateliers en conflit
        $this->listeAteliersEnConflit = array_values(array_filter($this->listeAteliersEnConflit));

        //Remet en odre les index de la liste des ateliers à pleine capacité
        $this->listeAteliersPleineCapacite = array_values(array_filter($this->listeAteliersPleineCapacite));
    }

    //Prend en paramètre une variable de temps en heures et la retourne en minutes
    private function tempsVersMinutes($variableTemps) {
        $minutes = 0;
        $x = explode(':', $variableTemps);
        return (int) $x[0] * 60 + 60 * ((int) $x[1] / 60);
    }

    //Prend en paramètre une variable de temps en minutes et la convertit en heures
    private function minutesVersTemps($variableMinutes) {
        $heures = (int) ($variableMinutes / 60);
        $minutes = (int) ($variableMinutes % 60);
        //Pour une question d'affichage
        if($minutes < 10){
          $minutes = "0".$minutes;
        }
        return (string) $heures . ":" . $minutes;
    }
}

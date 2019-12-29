<?php

namespace App\Http\Controllers;

use App\animateur;
use Illuminate\Http\Request;
use App\atelier;
use Validator;
use App\Constantes;
use App\Validation\ModelValidation;
use App\Model\VoirListeGestionAteliersViewModel;
use App\Model\VoirEnvoyerRappelViewModel;
use App\Model\VoirModifierConferencierViewModel;
use App\Model\VoirListeParticipantsViewModel;
use App\Model\VoirSupprimerConferencierViewModel;
use App\Model\ModifierAtelierViewModel;
use App\Model\VoirCreerAtelierViewModel;
use App\Model\VoirAnnulerAtelierViewModel;
use App\Model\ImprimerListePresenceViewModel;
use Illuminate\Support\Facades\DB;
use Mail;
use DateTime;

class AdministrateurController extends Controller {

    public function __construct(Request $request)
    {
        //Vérifie si l'utilisateur est un administrateur
        $this->middleware(Constantes::$MIDDLEWARE_ADMINISTRATEUR);
    }

    public function ImprimerListePresence(Request $request){
      $model = new ImprimerListePresenceViewModel();
      $model->GenererListe($request->numeroAtelier);

      return view('Administrateur/ImprimerListePresence')->with('model', $model);
    }

    //Retourne la vue da la liste des comptes
    public function VoirListeComptes() {
        return view('Administrateur/VoirListeComptes');
    }

    public function VoirGestionAteliers(Request $request){
      //Obtient le numéro du campus
      $idCampus = $request->campusSelectionne;

      //Obtient le numéro de l'utilisateur
      $idUtilisateur = session(Constantes::$ID_COMPTE);

      //Obtient l'onglet sélectionné
      $ongletSelectionne = $request->ongletSelectionne;

      //Obtient la date sélectionnée
      $dateSelectionnee = $request->dateSelectionnee;

      //Initialise le modèle
      $model = new VoirListeGestionAteliersViewModel();
      $model->GenererListe($idCampus, $dateSelectionnee, $ongletSelectionne);
        return view('Administrateur/VoirGestionAteliers')->with('model',$model);
    }

    //Atelier----------------------------------------------------------------------------------

    //Retourne la vue du formulaire de création d'un atelier
    public function VoirCreerAtelier() {
        $model = new VoirCreerAtelierViewModel();
        return view('Administrateur/VoirCreerAtelier')->with('model',$model);
    }

    //Insère l'atelier dans la base de données
    public function CreerAtelier(Request $request) {
        //Valide le modèle à l'aide des paramètres contenus dans la requête
        $validator = Validator::make($request->all(), modelValidation::AtelierValidation(), modelValidation::AtelierValidationMessages());
        //Vérifie si le modèle est non valide
        if ($validator->fails()) {
            //Retourne la vue avec les messages d'erreur
            return redirect()->action('AdministrateurController@VoirCreerAtelier')->withErrors($validator)->withInput($request->all);
        }

        //Initialise un atelier et lui assigne ses attributs
        $atelier = new atelier;
        $atelier->Nom = $request->Nom;
        $atelier->Endroit = $request->Endroit;
        $atelier->HeureDebut = $request->HeureDebut;
        $atelier->Duree = $request->Duree;
        $atelier->Description = $request->Description ?? "";
        $atelier->DateAtelier = $request->DateAtelier;
        $atelier->NombreDePlace = $request->NombreDePlace;
        $atelier->idCampus = $request->idCampus;
        $atelier->idProgramme = 0;

        //Sauvegarde l'atelier
        $atelier->save();

        //Trouve l'id de l'atelier qui vient d'être ajouté à la base données.
        $idAtelier = DB::table(Constantes::$TABLE_ATELIERS)->orderBy('id','desc')->first()->id;

        //Insertion des relations entre l'atelier et les conférenciers
        foreach (explode(";",$request->listeConferenciers) as $idConferencier) {
          DB::table(Constantes::$TABLE_LIEN_ATELIER_ANIMATEURS)->insert([Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_ANIMATEUR => $idAtelier, CONSTANTES::$COLUMN_ID_ANIMATEUR_LIEN_ATELIER_ANIMATEUR => $idConferencier]);
        }

        //Retourne un succès
        return "success";
    }

    public function VoirModifierAtelier(Request $request){
        $model = new ModifierAtelierViewModel($request->idAtelier);
        return view('Administrateur/VoirModifierAtelier')->with('model',$model);
    }

    public function ModifierAtelier(Request $request){
      //Extrait les données de la requête
      $idAtelier = $request->idAtelier;
      //Valide le modèle à l'aide des paramètres contenus dans la requête
      $validator = Validator::make($request->all(), modelValidation::AtelierValidation(), modelValidation::AtelierValidationMessages());
      //Vérifie si le modèle est non valide
      if ($validator->fails()) {
          //Retourne la vue avec les messages d'erreur
          $model = new ModifierAtelierViewModel($request->idAtelier);
          return redirect()->action('AdministrateurController@VoirModifierAtelier', ['idAtelier' => $request->idAtelier])->withErrors($validator)->withInput($request->all)->with('isOld',true);
      }
      //Si les inputs sont valides
      else{
        //Préserve la valeur actuelle du nombre de places disponibles
        $nombreDePlaces = DB::table(Constantes::$TABLE_ATELIERS)->where(Constantes::$COLUMN_ID_ATELIERS,'=',$idAtelier)->get()[0]->NombreDePlace;

        //Gère la liste d'attente et la liste des participants de cet atelier selon le changement apporté au nombre de places.
        $this->GestionModificationNombreDePlaces($nombreDePlaces, $request->NombreDePlace, $idAtelier);

        //Gère les conférenceirs
        $this->GestionLienAtelierAnimateur($idAtelier, explode(";",$request->listeConferenciers));
        //Modifie les informations de l'atelier
        DB::table(Constantes::$TABLE_ATELIERS)->where(Constantes::$COLUMN_ID_ATELIERS,'=',$idAtelier)->update([Constantes::$COLUMN_NOM_ATELIERS => $request->Nom,
        Constantes::$COLUMN_ENDROIT_ATELIERS => $request->Endroit, Constantes::$COLUMN_HEURE_DEBUT_ATELIERS => $request->HeureDebut,
        Constantes::$COLUMN_DUREE_ATELIERS => $request->Duree,Constantes::$COLUMN_DESCRIPTION_ATELIERS => $request->Description,
        Constantes::$COLUMN_DATE_ATELIER_ATELIERS => $request->DateAtelier, Constantes::$COLUMN_NOMBRE_DE_PLACE_ATELIERS => $request->NombreDePlace,
        Constantes::$COLUMN_ID_CAMPUS_ATELIERS => $request->idCampus,Constantes::$COLUMN_ID_Programme_ATELIERS => "0"]);
      }

      //Retourne un succès
      return "success";
    }

    public function VoirAnnulerAtelier(Request $request){
      $idAtelier = $request->idAtelier;

      $model = new VoirAnnulerAtelierViewModel($request->idAtelier);
      return view('Administrateur/VoirAnnulerAtelier')->with('model',$model);
    }

    //Retire l'atelier de la base de données
    public function AnnulationAtelier(Request $request) {
        $idAtelier = $request->numeroAtelier;

        //Trouve l'atelier qui possède le numéro d'atelier contenu dans la requête
        $atelier = DB::table('ateliers')->where('id', '=', $idAtelier)->get();

        //Trouve le campus
        $campus = DB::table(CONSTANTES::$TABLE_CAMPUSES)->where('id','=',$atelier[0]->idCampus)->get()[0];

        //Fait une liste de tous les éléments de la table lien_atelier_comptes qui contiennent l'id de l'atelier annulé
        $listeElementsLienAtelierComptes = DB::table('lien_atelier_comptes')->where('idAtelierLienAtelierCompte', '=', $idAtelier)->get();

        //Envoit un courriel à tous les utilisateurs de cette liste
        foreach ($listeElementsLienAtelierComptes as $lien) {
        //Trouve l'utilisateur
        $utilisateur = DB::table('comptes')->where('id', '=', (int) $lien->idCompteLienAtelierCompte)->get();
        $this->EnvoyerAvertissementAnnulation($atelier[0], $campus, $utilisateur[0]);
        }

        ///Fait une liste de tous les éléments de la table liste_attentes qui contiennent l'id de l'atelier annulé
        $listeElementsListeAttentes = DB::table('liste_attentes')->where('idAtelierListeAttentes', '=', $idAtelier)->get();

        //Envoit un courriel à tous les utilisateurs de cette liste
        foreach ($listeElementsListeAttentes as $lien) {
        //Trouve l'utilisateur
        $utilisateur = DB::table('comptes')->where('id', '=', (int) $lien->idCompteListeAttentes)->get();
        $this->EnvoyerAvertissementAnnulation($atelier[0], $campus, $utilisateur[0]);
        }

        //Supprime l'atelier de la base de données
        DB::table('ateliers')->where('id', '=', $idAtelier)->delete();

        //Retourne un succès
        return "success";
    }

    private function GestionLienAtelierAnimateur($idAtelier, $listeIdConferencier){
      //Supprime tous les liens avec les animateurs pour cet atelier
      DB::table(Constantes::$TABLE_LIEN_ATELIER_ANIMATEURS)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_ANIMATEUR, '=',$idAtelier)->delete();

      //Pour chaque conférencier dans la liste
      foreach ($listeIdConferencier as $idConferencier) {
        //Insère un lien
        DB::table(Constantes::$TABLE_LIEN_ATELIER_ANIMATEURS)->insert([Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_ANIMATEUR => (int) $idAtelier,Constantes::$COLUMN_ID_ANIMATEUR_LIEN_ATELIER_ANIMATEUR => (int)$idConferencier]);
      }

    }

    private function GestionModificationNombreDePlaces($nombreDePlacesActuelles, $nombreDePlacesFutures, $idAtelier){
        //Calcule la différence entre le nombre de places prévues et celles actuelles
        $difference = $nombreDePlacesFutures - $nombreDePlacesActuelles;


        //Si des places se sont ajoutées, transfère un nombre de personnes de la liste d'attente vers la liste des participants pour cet atelier égale à la différence.
        if($difference > 0){
            for($x = 0; $x < $difference; $x++){
              //Va dans la liste d'attente, trouve le premier utilisateur dans la liste d'attente.
              $premierUtilisateur = DB::table(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->where(Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES, '=', $idAtelier)->first();
              //Si la liste d'attente n'est pas vide
              if (isset($premierUtilisateur)) {

                  //Ajoute ce premier utilisateur dans la liste des participants de cet atelier
                  DB::table(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->insert([Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE => (int) $idAtelier,
                      Constantes::$COLUMN_ID_COMPTE_LIEN_ATELIER_COMPTE => (int) $premierUtilisateur->idCompteListeAttentes]);

                  //Trouve l'atelier affecté
                  $atelier = DB::table(Constantes::$TABLE_ATELIERS)->where('id', '=', $idAtelier)->get();

                  //Retire une place dans l'atelier
                  DB::table(Constantes::$TABLE_ATELIERS)->where('id', '=', $idAtelier)->update(['NombreDePlace' => $atelier[0]->NombreDePlace - 1]);


                  //Retire le premier utilisateur de la liste d'attente
                  DB::table(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->where([[Constantes::$COLUMN_ID_COMPTE_LISTE_ATTENTES, '=', $premierUtilisateur->idCompteListeAttentes],[Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES, '=', $idAtelier]])->delete();

                  //Trouve le compte du premier utilisateur
                  $comptePremierUtilisateur = DB::table('comptes')->where('id', '=', (int) $premierUtilisateur->idCompteListeAttentes)->get()[0];

                  //Envoit un courriel au premier utilisateur (cette fonction est en commentaire comme demandé en classe)
                  //$this->EnvoyerRappelListeAttentes($atelier[0], $campus, $comptePremierUtilisateur);
              }
              else {
                break;
              }
            }
        }
        //Sinon, si le nombre de places a diminué, retire un nombre de personne de la liste des participants égale à la valeur absolue de la différence
        elseif($difference < 0){
          //Initialise une variable qui contient la liste d'attentes pour cet atelier
          $listeAttentes = DB::table(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->where(Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES, '=', $idAtelier)->get();
          $nouvelleListeAttentes = array();
          for($x = 0; $x < abs($difference); $x++){
            //Va dans la liste des participants et trouve le dernier participants
            $dernierParticipant = DB::table(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where(Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $idAtelier)->orderBy('id','desc')->first();
            //Si la liste des participants n'est pas vide
            if (isset($dernierParticipant)) {
                //Ajoute ce dernier participant à la nouvelle liste d'attentes
                $nouvelleListeAttentes[] = $dernierParticipant;

                //Retire le dernier participant de la liste des participants
                DB::table(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where([[Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $idAtelier],[Constantes::$COLUMN_ID_COMPTE_LIEN_ATELIER_COMPTE, '=', $dernierParticipant->idCompteLienAtelierCompte]])->orderBy('id','desc')->delete();

                //Trouve le compte du dernier participant
                $compteDernierParticipant = DB::table('comptes')->where('id', '=', (int) $dernierParticipant->idCompteLienAtelierCompte)->get()[0];

                //Envoit un courriel au premier utilisateur (cette fonction est en commentaire comme demandé en classe)
                //$this->EnvoyerRappelListeAttentes($atelier[0], $campus, $comptePremierUtilisateur);
            }
            else{
              break;
            }
        }
        //Supprime la liste d'attentes actuelle de la base de données pour la remplacer par la nouvelle
        DB::table(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->where(Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES, '=', $idAtelier)->delete();

        //Inverse la nouvelle liste d'attentes.
        $nouvelleListeAttentes = array_reverse($nouvelleListeAttentes,true);
        //En premier, ajoute à la liste d'attentes ceux qui ont été retiré de la liste des participants
        foreach($nouvelleListeAttentes as $inscription){
          DB::table(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->insert([Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES => $inscription->idAtelierLienAtelierCompte,
              Constantes::$COLUMN_ID_COMPTE_LISTE_ATTENTES => $inscription->idCompteLienAtelierCompte]);
        }

        //Par la suite, remet dans la liste d'attentes ceux qui y étaient déjà.
        foreach($listeAttentes as $inscription){
          DB::table(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->insert([Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES => $inscription->idAtelierListeAttentes,
              Constantes::$COLUMN_ID_COMPTE_LISTE_ATTENTES => $inscription->idCompteListeAttentes]);
        }
      }
    }



    //Retourne la vue qui permet d'envoyer un message de rappel à tous les utilisateurs inscrits à un atelier
    public function VoirEnvoyerRappel() {

        //Initialise le modèle
        $model = new VoirEnvoyerRappelViewModel();

         //Retourne la vue de l'envoi de rappels
        return view('Administrateur/VoirEnvoyerRappel')->with('model', $model);
    }


    public function VoirEnvoyerRappelSpecifique(Request $request){
      $idAtelier = $request->idAtelier;

      return view('Administrateur/VoirEnvoyerRappelSpecifique')->with('idAtelier',$idAtelier);
    }

    //Envoit un courriel à tous les utilisateurs inscrits à l'atelier passé en paramètre
    public function EnvoyerRappelSpecifique(Request $request) {

        //Obtient le numéro de l'atelier
        $idAtelier = $request->numeroAtelier;

        //Trouve l'atelier qui possède le numéro d'atelier contenu dans la requête
        $atelier = DB::table('ateliers')->where('id', '=', $idAtelier)->get()[0];

        //Fait une liste de tous les éléments de la table lien_atelier_comptes qui contiennent l'id de l'atelier
        $listeElementsLienAtelierComptes = DB::table('lien_atelier_comptes')->where('idAtelierLienAtelierCompte', '=', $idAtelier)->get();

        //Envoit un courriel à tous les utilisateurs de cette liste (cette fonction est en commentaire comme demandé en classe)
        foreach ($listeElementsLienAtelierComptes as $lien) {
        //Trouve l'utilisateur
        $utilisateur = DB::table('comptes')->where('id', '=', (int) $lien->idCompteLienAtelierCompte)->get()[0];

        if(!is_null($utilisateur)){
            //Trouve le campus
            $campus = DB::table('campuses')->where('id', '=', $atelier->idCampus)->get()[0];
            try{
            Mail::send('Courriel/CourrielRappelSpecifique', ['atelier' => $atelier, 'campus' => $campus], function ($message) use($utilisateur) {
                $message->from('info@ssh-co.info', 'Semaine des sciences humaines');
                $message->to($utilisateur->Courriel)->subject("Rappel de participation à un atelier");
            });
          }catch (\Throwable $ex) {}
            }
        }

        //Retourne la route permettant d'afficher la vue de l'envoi de rappels
        return "success";
    }

    public function VoirEnvoyerRappelGenerique(){
      return view('Administrateur/VoirEnvoyerRappelGenerique');
    }

    //Envoit un courriel à tous les utilisateurs du site
    public function EnvoyerRappelGenerique() {
            //Initalise la liste de tout les utilisateurs
            $listeComptes = DB::table(constantes::$TABLE_COMPTES)->get();

            foreach ($listeComptes as $compte) {
              //Si l'utilisateur est un utilisateur
              if((int)($compte->idTypeCompte) == 1){
                //Envoit un courriel à l'utilisateur
                try{
                  Mail::send('Courriel/CourrielRappelGenerique', [], function ($message) use($compte) {
                      $message->from('info@ssh-co.info', 'Semaine des sciences humaines');
                      $message->to($compte->Courriel)->subject("Rappel de la semaine des sciences humaines");
                  });
                }
                catch (\Throwable $ex) {}
              }
            }

        return "success";
    }

    //Envoit un courriel générique lorsqu'un atelier est annulé
    private function EnvoyerAvertissementAnnulation($atelier, $campus, $utilisateur) {
      try{
        Mail::send('Courriel/CourrielNotificationAnnulation', ['atelier' => $atelier, 'campus' => $campus], function ($message) use($utilisateur) {
            $message->from('info@ssh-co.info', 'Semaine des sciences humaines');
            $message->to($utilisateur->Courriel)->subject("Avertissement d'annulation d'un atelier de formation");
        });
      }
      catch (\Throwable $ex) {}
    }

    // Permet de voir le formulaire de création d'un conférencier
    public function VoirCreerConferencier(){
        return view('Administrateur/VoirCreerConferencier');
    }

    // Permet de créer un conférencier
    public function CreerConferencier(Request $request){

        //Valide le modèle à l'aide des paramètres contenus dans la requête
        $validator = Validator::make($request->all(), modelValidation::ConferencierValidation(), modelValidation::ConferencierValidationMessages());

        //Vérifie si le modèle est non valide
       if ($validator->fails()) {

            //Retourne la vue avec les messages d'erreur
           return redirect()->route("VoirErreursCreerConferencier")->withErrors($validator)->withInput($request->all);
        }

        // Obtient l'onglet à choisir
        $onglet = 1;

        //Initialise un conférencier et lui assigne ses attributs
        // TODO: SUPPRIMER LES COLONNES QUI NE SONT PLUS LÀ
        $conferencier = new animateur;
        $conferencier->Nom = $request->Nom;
        $conferencier->Prenom = $request->Prenom;
        $conferencier->Biographie = $request->Biographie ?? "";
        $conferencier->Photo = $request->Photo ?? "";
        $conferencier->Courriel = $request->Courriel ?? "";
        $conferencier->Expertise = $request->Expertise;
        $conferencier->Actif = 1;

        //Sauvegarde le conférencier
        $conferencier->save();

        //Retourne la liste des conférenciers
        return $onglet;
    }

    // Permet de voir les erreurs de création
    public function VoirErreursCreerConferencier(){

        //Retourne la vue avec les erreurs
        return view('Administrateur/VoirErreursCreerConferencier');
    }

    // Permet de voir le formulaire de modification d'un conférencier
    public function VoirModifierConferencier(Request $request){

        // Crée le modèle contenant les informations du conférencier
        $model = new VoirModifierConferencierViewModel($request->Id);

         // Retourne la vue de modification
        return view('Administrateur/VoirModifierConferencier')->with('model', $model);
    }

    // Permet de modifier un conférencier
    public function ModifierConferencier(Request $request){

        //Valide le modèle à l'aide des paramètres contenus dans la requête
        $validator = Validator::make($request->all(), modelValidation::ModifierConferencierValidation(), modelValidation::ModifierConferencierValidationMessages());

        //Vérifie si le modèle est non valide
        if ($validator->fails()) {

            //Retourne la vue avec les messages d'erreur
            return redirect()->route("VoirErreursModifierConferencier")->withErrors($validator)->withInput($request->all);
        }

        // Obtient l'onglet à choisir
        $onglet = DB::table(CONSTANTES::$TABLE_CONFERENCIERS)->where(CONSTANTES::$COLUMN_ID, $request->Id)->get()[0]->Actif;

        $conferencier = DB::table(CONSTANTES::$TABLE_CONFERENCIERS)->where(CONSTANTES::$COLUMN_ID, $request->Id)->get()[0];

        // Vérifie si la photo a été changée avant de supprimer l'ancienne
        $photoChangee = ($request->Photo ?? "") != ($conferencier->Photo  ?? "") && $conferencier->Photo != "";
        if($photoChangee){

            // Supprime l'ancienne photo
            // Source: https://www.afterhoursprogramming.com/tutorial/php/delete-file/
            $monFichier = $conferencier-> Photo ?? "";
            $cheminVersMonFichier = fopen($monFichier, 'w') or die("Impossible d'ouvrir le fichier.");
            fclose($cheminVersMonFichier);
            $monFichier = "uploads/".$monFichier;
            unlink($monFichier) or die("Impossible de supprimer le fichier.");
        }

        //Obtient le conférencier à modifier et effectue les changements nécessaires
        DB::table(CONSTANTES::$TABLE_CONFERENCIERS)->where(CONSTANTES::$COLUMN_ID, $request->Id)
            ->update([
                'Nom' => $request->Nom,
                'Prenom' => $request->Prenom,
                'Courriel' => $request->Courriel ?? "",
                'Photo' => $request->Photo ?? "",
                'Biographie' => $request->Biographie ?? "",
                'Expertise' => $request->Expertise,
                'Actif' => $request->Actif,
                ]);

        //Retourne la liste des conférenciers
        return $onglet;
    }

    // Permet de voir les erreurs de modification
    public function VoirErreursModifierConferencier(Request $request){

        // Crée le modèle contenant les informations du conférencier
        $model = new VoirModifierConferencierViewModel($request->Id);

        //Retourne la vue avec les erreurs
        return view('Administrateur/VoirErreursModifierConferencier')->with('model', $model);
    }

    // Permet de voir la confirmation de la suppression d'un conférencier
    public function VoirSupprimerConferencier(Request $request){

        // Crée le modèle contenant les informations du conférencier
        $model = new VoirSupprimerConferencierViewModel($request->Id);

        // Retourne la vue de suppression
        return view('Administrateur/VoirSupprimerConferencier')->with('model', $model);
    }

    // Permet de supprimer un conférencier
    public function SupprimerConferencier(Request $request){
        //Trouve l'atelier qui possède le numéro d'atelier contenu dans la requête
        if(DB::table(CONSTANTES::$TABLE_CONFERENCIERS)->where('id', '=', $request->Id)->get()){

            // Vérifie si une photo est associée au conférencier
            if($request->Photo != ""){

                // Supprime la photo rattachée au conférencier
                // Source: https://www.afterhoursprogramming.com/tutorial/php/delete-file/
                $monFichier = $request->Photo ?? "";
                $cheminVersMonFichier = fopen($monFichier, 'w') or die("Impossible d'ouvrir le fichier.");
                fclose($cheminVersMonFichier);
                $monFichier = "uploads/".$monFichier;
                unlink($monFichier) or die("Impossible de supprimer le fichier.");
            }

            //Supprime les liens entre ce conférencier et tous les ateliers rattachés.
            DB::table(Constantes::$TABLE_LIEN_ATELIER_ANIMATEURS)->where(Constantes::$COLUMN_ID_ANIMATEUR_LIEN_ATELIER_ANIMATEUR,'=',$request->Id)->delete();

            //Supprime le conférencier de la base de données
            DB::table(CONSTANTES::$TABLE_CONFERENCIERS)->where('id', '=', $request->Id)->delete();
        }

        // Si la suppression a fonctionné, retourne un message de succès
        return redirect()->route("ListeConferenciers")->with( 'ongletChoisi', $request->ongletChoisi);
    }
}

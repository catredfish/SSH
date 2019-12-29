<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\VoirListeAteliersViewModel;
use App\Model\VoirModifierCompteViewModel;
use App\Model\VoirMessageErreurViewModel;
use App\Model\VoirListeParticipantsViewModel;
use App\Model\VoirListeConferenciersViewModel;
use App\Model\VoirConferencierViewModel;
use App\Model\VoirDescriptionAtelierViewModel;
use App\Model\VoirDescriptionConflitViewModel;
use App\lienAtelierCompte;
use App\Constantes;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Validation\ModelValidation;
use Mail;
use Illuminate\Support\Facades\Input;
use Session;
use Thread;

class UtilisateurController extends Controller {
    
    public function __construct(Request $request)
    {
        //Vérifie si l'usager est un utilisateur
        $this->middleware(Constantes::$MIDDLEWARE_UTILISATEUR);
    }


    public function VoirFormation() {
        return view('Utilisateur/VoirFormation');
    }

    //Retourne la vue contenant la liste des ateliers
    public function VoirListeAteliers(Request $request) {

        //Obtient le numéro du campus
        $idCampus = $request->numeroCampus;

        //Obtient le numéro de l'utilisateur
        $idUtilisateur = session(Constantes::$ID_COMPTE);

        //Obtient l'onglet sélectionné
        $ongletSelectionne = $request->ongletSelectionne;

        //Obtient la date sélectionnée
        $dateSelectionnee = $request->dateSelectionnee;

        //Initialise le modèle
        $model = new VoirListeAteliersViewModel();
        $model->GenererListe($idCampus, $idUtilisateur, $ongletSelectionne, $dateSelectionnee);

        //Retourne la vue avec son modèle
        return view('Utilisateur/VoirListeAteliers')->with('model', $model);
    }

    public function VoirListeParticipants(Request $request){

        $model = new VoirListeParticipantsViewModel();
        $model->GenererListe($request->numeroAtelier);

        return view('Utilisateur/VoirListeParticipants')->with('model', $model);
    }

    //Inscrit l'utilisateur à l'atelier
    public function InscriptionAtelier(Request $request) {

        //Obtient le numéro de l'atelier où l'utilisateur sera inscrit
        $idAtelier = $request->numeroAtelier;

        //Obtient le numéro du compte de l'utilisateur qui s'inscrit à cet atelier
        $idCompte = $request->numeroCompte;

        //Crée les paramètres qui seront utilisés pour le modèle de la vue
        $numeroOngletSelectionne = $request->numeroOngletSelectionne;
        $numeroCampus = $request->numeroCampus;
        $dateSelectionnee = $request->dateSelectionnee;

        //Trouve l'atelier où était inscrit l'utilisateur
        $atelier = DB::table('ateliers')->where('id', '=', $idAtelier)->get();

        //Trouve le campus sélectionné
        $campus = DB::table('campuses')->where('id', '=', $numeroCampus)->get()[0];

        //Trouve l'utilisateur
        $utilisateur = DB::table('comptes')->where('id', '=', $idCompte)->get()[0];

        //Si l'utilisateur est déjà inscrit à cet atelier, celui-ci est désinscrit
        if (DB::table(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where([[Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $idAtelier],
                    [Constantes::$COLUMN_ID_COMPTE_LIEN_ATELIER_COMPTE, '=', $idCompte]])->exists()) {

            //Désinscrit l'utilisateur
            DB::table(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->where([[Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE, '=', $idAtelier],
                [Constantes::$COLUMN_ID_COMPTE_LIEN_ATELIER_COMPTE, '=', $idCompte]])->delete();

            //Va dans la liste d'attente, trouve le premier utilisateur dans la liste d'attente pour cet atelier et l'ajoute à l'atelier
            $premierUtilisateur = DB::table(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->where(Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES, '=', $idAtelier)->get();
            if (count($premierUtilisateur) != 0) {
                DB::table(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->insert([Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE => (int) $idAtelier,
                    Constantes::$COLUMN_ID_COMPTE_LIEN_ATELIER_COMPTE => (int) $premierUtilisateur[0]->idCompteListeAttentes]);

                //Retire le premier utilisateur de la liste d'attente
                DB::table(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->where(Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES, '=', $idAtelier)->delete();

                //Trouve le compte du premier utilisateur
                $comptePremierUtilisateur = DB::table('comptes')->where('id', '=', (int) $premierUtilisateur[0]->idCompteListeAttentes)->get()[0];

                //Envoit un courriel au premier utilisateur (cette fonction est en commentaire comme demandé en classe)
                $this->EnvoyerRappelListeAttentes($atelier[0], $campus, $comptePremierUtilisateur);
            }
        }
        //Sinon, inscrit l'utilisateur à l'atelier
        else {
            //Inscrit l'utilisateur à l'atelier
            DB::table(Constantes::$TABLE_LIEN_ATELIER_COMPTES)->insert([Constantes::$COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE => (int) $idAtelier,
                Constantes::$COLUMN_ID_COMPTE_LIEN_ATELIER_COMPTE => (int) $idCompte]);
            
            //Envoit un courriel à l'utilisateur (cette fonction est en commentaire comme demandé en classe)
            $this->EnvoyerRappelInscriptionAtelier($atelier[0], $campus, $utilisateur);
        }

        //Retourne l'url permettant de voir la vue de la liste des ateliers (avec les paramètres sélectionnés)
        return "ListeAteliers?numeroCampus=" . $numeroCampus . "&ongletSelectionne=" . $numeroOngletSelectionne . "&dateSelectionnee=" . $dateSelectionnee;
    }

    //Ajoute un utilisateur à la liste d'attente
    public function InscriptionListeAttentes(Request $request) {

        //Extrait les données de la requête
        $idAtelier = $request->numeroAtelier;
        $idCompte = $request->numeroCompte;
        $numeroOngletSelectionne = $request->numeroOngletSelectionne;
        $numeroCampus = $request->numeroCampus;
        $dateSelectionnee = $request->dateSelectionnee;

        //Si l'utilisateur est déjà inscrit à cette liste d'attente, le désinscrit
        if (DB::table(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->where([[Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES, '=', $idAtelier],
                    [Constantes::$COLUMN_ID_COMPTE_LISTE_ATTENTES, '=', $idCompte]])->exists()) {

            //Désinscrit l'utilisateur
            DB::table(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->where([[Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES, '=', $idAtelier],
                [Constantes::$COLUMN_ID_COMPTE_LISTE_ATTENTES, '=', $idCompte]])->delete();
        }

        //Sinon, ajoute l'utilisateur à la liste d'attente
        else {

            //Ajoute l'utilisateur à la liste d'attente
            DB::table(Constantes::$TABLE_LIEN_LISTE_ATTENTES)->insert([Constantes::$COLUMN_ID_ATELIER_LISTE_ATTENTES => (int) $idAtelier,
                Constantes::$COLUMN_ID_COMPTE_LISTE_ATTENTES => (int) $idCompte]);
        }

        //Retourne l'url permettant de voir la vue de la liste des ateliers (avec les paramètres sélectionnés)
        return "ListeAteliers?numeroCampus=" . $numeroCampus . "&ongletSelectionne=" . $numeroOngletSelectionne . "&dateSelectionnee=" . $dateSelectionnee;
    }

    //Affiche le formulaire permettant de modifier les informations d'un compte utilisateur
    public function VoirModifierCompte(Request $request) {
        $model = new VoirModifierCompteViewModel(session()->get('idCompte'));

        //Retourne la vue permettant de modifier les informations d'un compte utilisateur
        return view('Utilisateur/VoirModifierCompte')->with('model', $model);
    }

    //Permet de modifier les informations d'un compte dans la base de données
    public function ModifierCompte(Request $request) {
        //Si l'utilisateur est connecté
        if(DB::table('comptes')->where('id', $request->session()->get('idCompte'))->exists()){

          //Ajoute l'id de l'utilisateur dans la requête
          $request->request->add(['id' => $request->session()->get('idCompte')]);

          switch ($request->typeConnexion) {
            case '1':
              $validator = Validator::make($request->all(), modelValidation::ModifierCompteEtudiantValidation(), modelValidation::ModifierCompteEtudiantValidationMessages());
              break;
            case '2':
              $validator = Validator::make($request->all(), modelValidation::ModifierCompteEmployeValidation(), modelValidation::ModifierCompteEmployeValidationMessages());
              break;
            case '3':
              $validator = Validator::make($request->all(), modelValidation::ModifierCompteVisiteurValidation(), modelValidation::ModifierCompteVisiteurValidationMessages());
              break;
            default:
              // code...
              break;
          }

          //Vérifie si le modèle est non valide
          if ($validator->fails()) {
              //Si tel est le cas, affiche la vue avec les messages d'erreur
              return redirect()->route("VoirModifierCompte")->withErrors($validator)->withInput($request->all)->with('isOld',true);
          }

          //Sinon, modifie le compte
          else {

              //Modifie les informations du compte
              DB::table('comptes')->where('id', $request->session()->get('idCompte'))->update(['NumeroIdentification' => $request->NumeroIdentification, 'Nom' => $request->Nom,
              'Prenom' => $request->Prenom, 'Courriel' => $request->Courriel, 'MotDePasse' => password_hash($request->MotDePasse, PASSWORD_DEFAULT),'idTypeConnexion' => $request->typeConnexion, 'idProgramme' => $request->programme]);

              //Redirige vers la page d'accueil
              return redirect()->route('voirAccueil');
          }
        }
        else{
          //Retourne un message d'erreur
          return redirect()->route('MessageErreur');
        }
    }

    //Envoit un courriel avec les informations de l'atelier et du campus à un utilisateur donné en paramètre
    private function EnvoyerRappelListeAttentes($atelier, $campus, $utilisateur) {
        try {
            Mail::send('Courriel/CourrielNotificationListeAttente', ['atelier' => $atelier, 'campus' => $campus], function ($message) use($utilisateur) {
                $message->from('info@ssh-co.info', 'Semaine des sciences humaines');
                $message->to($utilisateur->Courriel)->subject("Confirmation d'inscription à la liste d'attente");
            });
        } catch (\Throwable $ex) {}
    }

    //Envoit un courriel avec les informations de l'atelier et du campus à un utilisateur donné en paramètre.
    private function EnvoyerRappelInscriptionAtelier($atelier, $campus, $utilisateur) {
      try {
          
          Mail::send('Courriel/CourrielNotificationInscriptionAtelier', ['atelier' => $atelier, 'campus' => $campus], function ($message) use($utilisateur) {
              $message->from('info@ssh-co.info', 'Semaine des sciences humaines');
              $message->to($utilisateur->Courriel)->subject("Confirmation d'inscription à un atelier");
          });
          
      } catch (\Throwable $ex) {}
    }

    //Affiche les informations du compte
    public function VoirCompte() {
        return view('Utilisateur/VoirCompte');
    }

    public function AfficherDescriptionAtelier(Request $request){
        //Extrait les données de la requête
        $numeroAtelier = $request->numeroAtelier;
        
        $model = new VoirDescriptionAtelierViewModel($numeroAtelier);
        //Retourne la description de cet ateliers
        return view('Utilisateur/VoirDescriptionAtelier')->with('model', $model);
    }

    // Affiche la liste des conférenciers
    public function VoirListeConferenciers(){

        // Crée le modèle pour la vue
        $model = new VoirListeConferenciersViewModel();

        // Spécifie l'onglet sélectionné si besoin est
        if(Input::has('ongletChoisi'))
        {
            $model->setOngletSelectionne(Input::get('ongletChoisi'));
        }
        else if(Session::has('ongletChoisi')){
            $model->setOngletSelectionne(Session::get('ongletChoisi'));
        }

        // Vérifie si l'utilisateur est un administrateur
        $estAdministrateur = session()->get(Constantes::$ID_TYPE_DE_COMPTE) >= Constantes::$ID_ADMINISTRATEUR ? true : false;

        // Génère la liste de conférenciers
        $model->GenererListe($estAdministrateur);

        // Retourne la vue avec un modèle
        return view('Utilisateur/VoirListeConferenciers')->with('model', $model);
    }

    // Permet de voir les informations d'un conférencier
    public function VoirConferencier(Request $request){

        // Crée le modèle contenant les informations du conférencier
        $model = new VoirConferencierViewModel($request->Id);

        // Retourne la vue
        return view('Utilisateur/VoirConferencier')->with('model', $model);
    }

    //Permet de voir la source d'un conflit d'un atelier.
    public function VoirDescriptionConflit(Request $request){

              //Obtient le numéro du campus
              $idCampus = $request->numeroCampus;

              //Obtient le numéro de l'utilisateur
              $idUtilisateur = session(Constantes::$ID_COMPTE);

              //Obtient l'onglet sélectionné
              $ongletSelectionne = $request->ongletSelectionne;

              //Obtient la date sélectionnée
              $dateSelectionnee = $request->dateSelectionnee;

              //Initialise le modèle
              $model = new VoirDescriptionConflitViewModel();
              $model->GenererListe($idCampus, $idUtilisateur, $ongletSelectionne, $dateSelectionnee, $request->numeroAtelier);

        // Retourne la vue
        return view('Utilisateur/VoirDescriptionConflit')->with('model', $model);
    }

    public function VoirInscriptionAtelier(Request $request){
      //Extrait les données de la requête
      $numeroAtelier = $request->numeroAtelier;

      $model = new VoirDescriptionAtelierViewModel($numeroAtelier);

      return view('Utilisateur/VoirInscriptionAtelier')->with('model', $model);
    }

    public function VoirDesinscriptionAtelier(Request $request){
      //Extrait les données de la requête
      $numeroAtelier = $request->numeroAtelier;

      $model = new VoirDescriptionAtelierViewModel($numeroAtelier);

      return view('Utilisateur/VoirDesinscriptionAtelier')->with('model', $model);
    }

    public function VoirInscriptionListeAttentes(Request $request){
      //Extrait les données de la requête
      $numeroAtelier = $request->numeroAtelier;

      $model = new VoirDescriptionAtelierViewModel($numeroAtelier);

      return view('Utilisateur/VoirInscriptionListeAttentes')->with('model', $model);
    }

    public function VoirDesinscriptionListeAttentes(Request $request){
      //Extrait les données de la requête
      $numeroAtelier = $request->numeroAtelier;

      $model = new VoirDescriptionAtelierViewModel($numeroAtelier);

      return view('Utilisateur/VoirDesinscriptionListeAttentes')->with('model', $model);
    }

    // Permet de voir les informations d'un conférencier dans le contexte d'un click dans la description d'un atelier.
    public function VoirConferencierDescriptionAtelier(Request $request){
        // Crée le modèle contenant les informations du conférencier
        $model = new VoirConferencierViewModel($request->Id);
        $idAtelier = $request->idAtelier;
        // Retourne la vue
        return view('Utilisateur/VoirConferencierDescriptionAtelier')->with('model', $model)->with('idAtelier',$idAtelier);
    }
}

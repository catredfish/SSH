<?php

namespace App\Http\Controllers;

use App\compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Validation\ModelValidation;
use App\Constantes;
use App\Model\VoirFormulaireInscriptionViewModel;
use Validator;

class VisiteurController extends Controller {

    //Retourne la vue de la page d'accueil
    public function VoirAccueil() {
        return view('Visiteur/VoirAccueil');
    }

    //Retourne la vue de la page de connexion
    public function VoirConnexion() {
        return view('Visiteur/VoirConnexion');
    }

    //Retourne la vue de la page d'inscription
    public function VoirInscription() {
        return view('Visiteur/VoirInscription');
    }

    public function VoirFormulaireInscription(Request $request){
      $typeConnexion = $request->typeConnexion;

      $model = new VoirFormulaireInscriptionViewModel((int)$typeConnexion);
      return view('Visiteur/VoirFormulaireInscription')->with('model',$model);
    }

    public function TESTSUPPRIMER(Request $request){
      $typeConnexion = $request->typeConnexion;
      return view('Visiteur/VoirFormulaireInscription')->with('typeConnexion',$typeConnexion);
    }

    //Valide une tentative de connexion de l'utilisateur
    public function Connexion(Request $request) {
      $typeConnexion =  $request->typeConnexion;

        switch ($request->typeConnexion) {
          case 'etudiant':
            //Valide le modèle
            $validator = Validator::make($request->all(), modelValidation::ConnexionValidationEtudiant(), modelValidation::ConnexionValidationEtudiantMessages());
            break;
          case 'employe':
            //Valide le modèle
            $validator = Validator::make($request->all(), modelValidation::ConnexionValidationEmploye(), modelValidation::ConnexionValidationEmployeMessages());
            break;
          case 'courriel':
            //Valide le modèle
            $validator = Validator::make($request->all(), modelValidation::ConnexionValidationCourriel(), modelValidation::ConnexionValidationCourrielMessages());
            break;
          default :
            //Message d'erreur
            break;
        }


        //Vérifie si la connexion n'a pas été fructueuse
        if ($validator->fails()) {
            //En cas d'erreur, affiche la vue avec les erreurs
            return redirect()->back()->withErrors($validator)->withInput($request->all)->with('typeConnexion', $typeConnexion);
        }

        //Si la connexion a été fructueuse, connecte l'utilisateur
        else {
            //Déclare la variable compte qui contiendra les informations du compte connecté.
            $compte;
            switch ($request->typeConnexion) {
              case 'etudiant':
                //Trouve le compte correspondant
                $compte = DB::table(Constantes::$TABLE_COMPTES)->where('NumeroIdentification', '=', $request->log)->get();
                break;
              case 'employe':
                //Trouve le compte correspondant
                $compte = DB::table(Constantes::$TABLE_COMPTES)->where('NumeroIdentification', '=', $request->log)->get();
                break;
              case 'courriel':
                //Trouve le compte correspondant
                $compte = DB::table(Constantes::$TABLE_COMPTES)->where('Courriel', '=', $request->log)->get();
                break;
              default:
                //Message d'erreur
                break;
            }
            //Vérifie si le compte est actif ou non
            if($compte[0]->Actif == 1){
              //Met à jour la session
              session([Constantes::$ID_COMPTE => $compte[0]->id]);
              session([Constantes::$ID_TYPE_DE_COMPTE => $compte[0]->idTypeCompte]);
              session([Constantes::$ID_TYPE_DE_CONNEXION => $compte[0]->idTypeConnexion]);
            }
            //Sinon, retourne un message d'erreur
            else{
              return redirect()->route('MessageErreur');
            }
            //Redirige vers la page d'accueil
            return redirect()->route('voirAccueil');
        }
    }

    //Permet à l'utilisateur de se déconnecter
    public function Deconnexion() {

        //Vide la session
        session()->pull(Constantes::$ID_COMPTE);
        session()->pull(Constantes::$ID_TYPE_DE_COMPTE);
        session()->pull(Constantes::$ID_TYPE_DE_CONNEXION);

        //Redirige vers la page d'accueil
        return redirect()->route('voirAccueil');
    }

    //Insère un compte au sein de la base de données
    public function CreerCompte(Request $request) {
        $typeConnexion = $request->typeConnexion;
        //Met l'attribut programme en int
        $request->programme = (int)($request->programme);
        //Valide le modèle selon le type de connexionType
        switch ($typeConnexion) {
          case '1':
            $validator = Validator::make($request->all(), modelValidation::CompteEtudiantValidation(), modelValidation::CompteEtudiantValidationMessages());
            break;
          case '2':
            $validator = Validator::make($request->all(), modelValidation::CompteEmployeValidation(), modelValidation::CompteEmployeValidationMessages());
            break;
          case '3':
            $validator = Validator::make($request->all(), modelValidation::CompteVisiteurValidation(), modelValidation::CompteVisiteurValidationMessages());
            break;
        }

        //Vérifie si le modèle est non valide
        if ($validator->fails()) {
            //Si tel est le cas, retourne la vue avec les erreurs
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        //Sinon, crée un nouveau compte
        else{

        //Crée les informations du nouveau compte
        $compte = new compte;
        //Si le type le type de compte est un employé ou un étudiant
        if(isset($request->NumeroIdentification)){
          $compte->NumeroIdentification = $request->NumeroIdentification;
          $compte->idProgramme = $request->programme;
        }
        else {
          $compte->NumeroIdentification = NULL;
          $compte->idProgramme = NULL;
        }
        $compte->Nom = $request->Nom;
        $compte->Prenom = $request->Prenom;
        $compte->Courriel = $request->Courriel;
        $compte->MotDePasse = password_hash($request->MotDePasse, PASSWORD_DEFAULT);
        $compte->idTypeCompte = 1;
        $compte->idTypeConnexion = (int)$typeConnexion;
        $compte->Actif = 1;


        //Sauvegarde le compte
        $compte->save();

        //Effectue une connexion automatique
        $connexion;


        $compteExtrait;

        //Si la connexion est valide
        switch ($typeConnexion) {
          case '1':
          case '2':
            //Extrait le compte de la base de données
            $compteExtrait = DB::table('comptes')->where('NumeroIdentification', '=', $request->NumeroIdentification)->get()[0];
            if (password_verify($request->MotDePasse,$compteExtrait->MotDePasse)){
                //Sauvegarde les attributs dans la session
                session([Constantes::$ID_COMPTE => $compteExtrait->id]);
                session([Constantes::$ID_TYPE_DE_COMPTE => $compteExtrait->idTypeCompte]);
                session([Constantes::$ID_TYPE_DE_CONNEXION => $compteExtrait->idTypeConnexion]);
            }
            break;
          case '3':
            //Extrait le compte de la base de données
            $compteExtrait = DB::table('comptes')->where('Courriel', '=', $request->Courriel)->get()[0];
            if (password_verify($request->MotDePasse, $compteExtrait->MotDePasse)) {
                //Sauvegarde les attributs dans la session
                session([Constantes::$ID_COMPTE => $compteExtrait->id]);
                session([Constantes::$ID_TYPE_DE_COMPTE => $compteExtrait->idTypeCompte]);
                session([Constantes::$ID_TYPE_DE_CONNEXION => $compteExtrait->idTypeConnexion]);
            }
            break;
        }
        //Redirige vers la page d'accueil
        return redirect()->route('voirAccueil');
        }
    }

    public function VoirMessageErreur(){
      return view('Shared/VoirMessageErreur');
    }
}

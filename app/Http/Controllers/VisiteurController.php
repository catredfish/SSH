<?php

namespace App\Http\Controllers;

use App\compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Validation\ModelValidation;
use App\Constantes;
use App\Model\VoirFormulaireInscriptionViewModel;
use App\Model\VoirMessageSuccesViewModel;
use App\Model\VoirMessageErreurViewModel;
use App\Model\VoirReinitialisationOublieMotDePasseViewModel;
use App\Guid;
use Validator;
use DateTime;
use Mail;

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
    
    //Retourne la vue de l'oublie de mot de passe
    public function VoirOublieMotDePasse() {
        return view('Visiteur/VoirOublieMotDePasse');
    }
    
    public function VoirReinitialisationOublieMotDePasse(Request $request){
        
        //Vérifie que le courriel envoyé correspond bien à celui d'un utilisateur enregistré 
        if(compte::where(Constantes::$COLUMN_COURRIEL_COMPTE, $request->Courriel)->get()->count() > 0){
            
            //Obtient les informations du compte de l'utilisateur
            $compte = compte::where(Constantes::$COLUMN_COURRIEL_COMPTE, $request->Courriel)->get()[0];
            
            //vérifie que le jeton reçu correspond à celui de l'utilisateur 
            if(password_verify($request->Jeton, $compte->Jeton)){
                
                $model = new VoirReinitialisationOublieMotDePasseViewModel($compte->Courriel, $request->Jeton);

                //Retourne la vue avec le courriel de l'utilisateur
                return view('Visiteur/VoirReinitialisationOublieMotDePasse')->with('model', $model);            
            }
        }
        else{
            return  redirect()->route('MessageErreur',['titre' => "Une erreur est survenue","message" => "Le jeton de réinitialisation de mot de passe entré est échu ou non valide. Veuillez vérifier votre courriel de nouveau ou faire la demande pour un nouveau jeton de réinitialisation de mot de passe à l'aide de la <a href='/OublieMotDePasse'>section du site Web prévue à cet effet.</a>",'retourAccueil' => true]);
        }
    }
    
    public function ReinitialisationOublieMotDePasse(Request $request){
        //Vérifie que le courriel envoyé correspond bien à celui d'un utilisateur enregistré 
        if(compte::where(Constantes::$COLUMN_COURRIEL_COMPTE, $request->Courriel)->get()->count() > 0){
            
            //Obtient les informations du compte de l'utilisateur
            $compte = compte::where(Constantes::$COLUMN_COURRIEL_COMPTE, $request->Courriel)->get()[0];
                      
            //vérifie que le jeton reçu correspond à celui de l'utilisateur 
            if(password_verify($request->Jeton, $compte->Jeton)){
                //Valide les informations du formulaire
                $validator = Validator::make($request->all(), modelValidation::ReinitialisationOublieMotDePasse(), modelValidation::ReinitialisationOublieMotDePasseMessages());
                
                
                //Vérifie si le modèle est non valide
                if ($validator->fails()) {
                    //Si tel est le cas, affiche la vue avec les messages d'erreur
                    return redirect()->route("VoirReinitialisationOublieMotDePasse",["Courriel" => $request->Courriel, "Jeton" => $request->Jeton ])->withErrors($validator)->withInput($request->all)->with('isOld',true);
                }
                //Sinon, modifie le mot de passe
                else{
                    $compte->MotDePasse = password_hash($request->MotDePasse,PASSWORD_DEFAULT);
                    //Sauvegarde les modifications
                    $compte->save();
                    //Retourne un message de succès
                    return  redirect()->route('MessageSucces',['titre' => "Le mot de passe a été réinitialisé avec succès","message" => "Le nouveau mot de passe 
                    entré pour votre compte est maintenant en vigueur. Si vous désirez le changer à nouveau, veuillez vous rendre à cette section du site Web.
                    Si vous désirez plutôt vous connecter à votre compte à l'aide de votre nouveau mot de passe, veuillez vous rendre à <a href='/Connexion'>cette section-ci du site Web.</a>",'retourAccueil' => true]);
                }
            }
        }
        else{
            return  redirect()->route('MessageErreur',['titre' => "Une erreur est survenue","message" => "Le jeton de réinitialisation de mot de passe entré est échu ou non valide. Veuillez vérifier votre courriel de nouveau ou faire la demande pour un nouveau jeton de réinitialisation de mot de passe à l'aide de la <a href='/OublieMotDePasse'>section du site Web prévue à cet effet.</a>",'retourAccueil' => true]);
        }
        
    }
    
    public function EnvoyerCourrielOublieMotDePasse(Request $request) {
        
        $validator = Validator::make($request->all(), modelValidation::EnvoyerCourrielOublieMotDePasseValidation(), modelValidation::EnvoyerCourrielOublieMotDePasseValidationMessages());
                 
        //Vérifie si le courriel est présent dans la base de données
        if ($validator->fails()) {
            //En cas d'erreur, affiche la vue avec les erreurs
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        else{
            //Obtient les informations pour le compte
            //$compte = DB::table(Constantes::$TABLE_COMPTES)->where(Constantes::$COLUMN_COURRIEL_COMPTE, $request->Courriel)->get()[0];
            $compte = compte::where(Constantes::$COLUMN_COURRIEL_COMPTE, $request->Courriel)->get()[0];
          
            //Obtient la différence en jour entre le dernier envoi de jeton et la date d'aujoud'hui
            $differenceDate = date_diff(new Datetime($compte->DateJetonEnvoye??date("Y-m-d H:i:s")),new Datetime(date("Y-m-d H:i:s")))->format('%d');
            //Vérifie si la limite d'envoi de jeton a été atteinte pour la journée
            if($compte->Jeton == null || $compte->NombreJetonEnvoye < 3 || $differenceDate >= 1){
                              
                //Vérifie si la limite d'envoi de jeton doit être réinitialise
                //On doit la réinitialiser si le jour de la date de l'envoi du jeton précède la date d'aujourd'hui
                if($differenceDate >= 1){
                    //Remet le compteur à 0
                    $compte->NombreJetonEnvoye = 0;    
                }
                
                //Met à jour la date d'envoi du jeton
                $compte->DateJetonEnvoye = date("Y-m-d H:i:s");
                
                
                
                $guid = Guid::getGUID();

                //Tant que le guid n'est pas unique, en trouve un second
                $guidDoublons = 1;

                while($guidDoublons > 0){
                    //Trouve un guid pour cette réinitialisation de mot de passe
                    $guid = Guid::getGUID();
                    $guidDoublons = DB::table(Constantes::$TABLE_COMPTES)->where(Constantes::$COLUMN_JETON_COMPTE, $guid)->get()->count();
                }

                //Met à jour le guid de l'utilisateur
                $compte->Jeton = password_hash($guid,PASSWORD_DEFAULT);
                
                //Met à jour le compte avec les nouvelles informations
                $compte->save();
                
                //Envoi un courriel à l'utilisateur qui lui permettra de réinitialiser son mot de passe 
                //Envoit un courriel générique lorsqu'un atelier est annulé
  
               try{
                  Mail::send('Courriel/CourrielOublieMotDePasse', ['jeton' => $guid,'courriel' => $compte->Courriel], function ($message) use($compte) {
                      $message->from('info@ssh-co.info', 'Semaine des sciences humaines');
                      $message->to($compte->Courriel)->subject("Réinitialisation de mot de passe");
                  });
               }
               //Si il y a une erreur lors de l'envoi du courriel, en avertit l'utilisateur
               catch (\Throwable $ex){
                   //
                   return  redirect()->route('MessageErreur',['titre' => "Une erreur est survenue","message" => "Une erreur est survenue lors de l'envoi du courriel. Veuillez réessayer à nouveau."]);
               }
                
               
               //Ajoute 1 au compteur de jeton
               $compte->NombreJetonEnvoye += 1;
    
                //Si le courriel est envoyé avec succès, envoie un message de succès.
                return  redirect()->route('MessageSucces',['titre' => "Le courriel a été envoyé avec succès","message" => "Un courriel à été envoyé à votre adresse courriel. Pour réinitialiser votre mot de passe, veuillez ouvrir le courriel et cliquez sur le lien «Réinitalisez votre mot de passe».",'retourAccueil' => true]);
            }
            //Si la limite de jeton pour la journée est atteinte
            else{
                
                //Retourne un message d'erreur              
                return  redirect()->route('MessageErreur',['titre' => "Le nombre d'essais par jour a été dépassé.","message" => "Le nombre de demandes de réinitialisation de mot de passe en cas d'oubli de mot de passe
                a été atteint. Veuillez attendre à demain avant de soumettre une nouvelle demande.",'retourAccueil' => true]);
                
            }
            
        }     
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

    public function VoirMessageErreur(Request $request){
        $model = new VoirMessageErreurViewModel($request->titre, $request->message, $request->retourAccueil);
        return view('Shared/VoirMessageErreur')->with('model',$model);
    }
    
    public function VoirMessageSucces(Request $request){
      $model = new VoirMessageSuccesViewModel($request->titre, $request->message, $request->retourAccueil);            
      return view('Shared/VoirMessageSucces')->with('model',$model);
    }
    
    public function VoirCourrielOublieMotDePasse(Request $request){
        
    }
}

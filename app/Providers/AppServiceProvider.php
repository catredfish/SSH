<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Constantes;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Validator::extend('validerConnexion', function ($field, $value, $parameters, $validator) {
            //Obtient le courriel
            $log = array_get($validator->getData(), $parameters[0]);
            //Obtient le mot de passe
            $motDePasse = array_get($validator->getData(), $parameters[1]);
            //Obtient le type de Connexion
            $typeConnexion = array_get($validator->getData(), $parameters[2]);

            $compte;
            //Retourne si oui ou non la combinaison du courriel ou du numéro d'identification et du mot de passe est valide.
            switch ($typeConnexion) {

              case 'etudiant':
                if(DB::table('comptes')->where('NumeroIdentification', '=', $log)->exists()){
                  //Trouve le compte
                  $compte = DB::table('comptes')->where('NumeroIdentification', '=', $log)->get()[0];
                }
                else{
                  return FALSE;
                }
                return password_verify($motDePasse, $compte->MotDePasse);;
                break;
              case 'employe':
                if(DB::table('comptes')->where('NumeroIdentification', '=', $log)->exists()){
                  //Trouve le compte
                  $compte = DB::table('comptes')->where('NumeroIdentification', '=', $log)->get()[0];
                }
                else{
                  return FALSE;
                }
                return password_verify($motDePasse, $compte->MotDePasse);;
                break;
              case 'courriel':
                if(DB::table('comptes')->where('Courriel', '=', $log)->exists()){
                  //Trouve le compte
                  $compte = DB::table('comptes')->where('Courriel', '=', $log)->get()[0];
                }
                else{
                  return FALSE;
                }
                return password_verify($motDePasse, $compte->MotDePasse);;
                break;
            }
        },"Le mot de passe est non valide.");

        Validator::extend('validerDuree', function ($field, $value, $parameters, $validator) {
            $regexArrayOut;
            //Obtient la durée
            $duree = array_get($validator->getData(), $parameters[0]);
            //Valide le format
            preg_match("/^[0-9]{1,2}:[0-9]{2}$/",(string)$duree,$regexArrayOut);
            //Si le format est invalide
            if(count($regexArrayOut) == 0){
                return false;
            }

            //Valide les heures et les minutes
            $x=explode(':',$duree);
            if((int)$x[0] > 24 || (int)$x[1] > 59 || (int)$x[0] < 0 || (int)$x[1] < 0){
                return false;
            }

            return true;
        },"Le format de la durée de l'atelier est invalide.\nLe Format valide est le suivant : 99:59.");

        Validator::extend('validerCourriel', function ($field, $value, $parameters, $validator) {
            //Obtient le courriel
            $courriel = array_get($validator->getData(), $parameters[0]);
            //Si le courriel n'est pas utilisé, le courriel est validé.
            if(count(DB::table('comptes')->where('Courriel', '=', $courriel)->get()) == 0){
                return true;
            }
            //Sinon il est invalide.
            else{
                return false;
            }
        },"Ce courriel est déjà utilisé. Veuillez en utiliser un autre.");
        Validator::extend('validerCourrielModifierCompte', function ($field, $value, $parameters, $validator) {
            //Obtient le courriel
            $courriel = array_get($validator->getData(), $parameters[0]);
            //Obtient l'id du compte
            $idCompte = array_get($validator->getData(), $parameters[1]);
            //Si le courriel n'est pas utilis�, le courriel est valid�
            if(count(DB::table('comptes')->where([['Courriel', '=', $courriel],['id','!=',$idCompte]])->get()) == 0 ){
                return true;
            }
            //Sinon il est invalide.
            else{
                return false;
            }
        },"Ce courriel est déjà utilisé. Veuillez en utiliser un autre.");

        Validator::extend('validerProgramme', function ($field, $value, $parameters, $validator) {
            //Obtient l'id du programme
            $programme = array_get($validator->getData(), $parameters[0]);

            //Si le courriel n'est pas utilis�, le courriel est valid�
            if($programme >= 1 && $programme <= 31){
                return true;
            }
        },"Vous devez choisir un programme d'études.");
        Validator::extend('validerCourrielConferencier', function ($field, $value, $parameters, $validator) {

            //Obtient le courriel
            $courriel = array_get($validator->getData(), $parameters[0]);

            //Si le courriel n'est pas utilisé, le courriel est validé.
            if(count(DB::table('animateurs')->where('Courriel', '=', $courriel)->get()) == 0){
                return true;
            }

            //Sinon il est invalide.
            else{
                return false;
            }
        },"Ce courriel est déjà utilisé. Veuillez en utiliser un autre.");

        Validator::extend('validerModificationCourrielConferencier', function ($field, $value, $parameters, $validator) {

            //Obtient le courriel
            $courriel = array_get($validator->getData(), $parameters[0]);

            //Obtient l'id du conférencier
            $idConferencier = array_get($validator->getData(), $parameters[1]);

             //Si le courriel n'est pas utilisé, le courriel est validé.
            if(count(DB::table('animateurs')->where([['Courriel', '=', $courriel],['id','!=',$idConferencier]])->get()) == 0 ){
                return true;
            }
            //Sinon il est invalide.
            else{
                return false;
            }
        },"Ce courriel est déjà utilisé. Veuillez en utiliser un autre.");
        Validator::extend('validerNumeroEtudiant', function ($field, $value, $parameters, $validator) {
            //Obtient le numéro
            $numeroIdentification = array_get($validator->getData(), $parameters[0]);
            //Si le numéro d'identification n'est pas déjà utilisé
            if(count(DB::table(Constantes::$TABLE_COMPTES)->where(Constantes::$COLUMN_NUMERO_IDENTIFICATION, '=', $numeroIdentification)->get()) == 0 ){
                return true;
            }
            //Sinon il est invalide.
            else{
                return false;
            }
        },"Ce numéro d'étudiant est déjà utilisé. Veuillez en utiliser un autre.");

        Validator::extend('validerNumeroEmploye', function ($field, $value, $parameters, $validator) {
            //Obtient le numéro
            $numeroIdentification = array_get($validator->getData(), $parameters[0]);
            //Si le numéro d'identification n'est pas déjà utilisé
            if(count(DB::table(Constantes::$TABLE_COMPTES)->where(Constantes::$COLUMN_NUMERO_IDENTIFICATION, '=', $numeroIdentification)->get()) == 0 ){
                return true;
            }
            //Sinon il est invalide.
            else{
                return false;
            }
        },"Ce numéro d'employé est déjà utilisé. Veuillez en utiliser un autre.");

        Validator::extend('validerNumeroEtudiantModifierCompte', function ($field, $value, $parameters, $validator) {
            //Obtient le numéro
            $numeroIdentification = array_get($validator->getData(), $parameters[0]);
            //Obtient l'id du compte
            $idCompte = array_get($validator->getData(), $parameters[1]);
            //Si le numéro d'identification n'est pas déjà utilisé
            if(count(DB::table(Constantes::$TABLE_COMPTES)->where([[Constantes::$COLUMN_NUMERO_IDENTIFICATION, '=', $numeroIdentification],['id','!=',$idCompte]])->get()) == 0 ){
                return true;
            }
            //Sinon il est invalide.
            else{
                return false;
            }
        },"Ce numéro d'étudiant est déjà utilisé. Veuillez en utiliser un autre.");

        Validator::extend('validerNumeroEmployeModifierCompte', function ($field, $value, $parameters, $validator) {
            //Obtient le numéro
            $numeroIdentification = array_get($validator->getData(), $parameters[0]);
            //Obtient l'id du compte
            $idCompte = array_get($validator->getData(), $parameters[1]);
            //Si le numéro d'identification n'est pas déjà utilisé
            if(count(DB::table(Constantes::$TABLE_COMPTES)->where([[Constantes::$COLUMN_NUMERO_IDENTIFICATION, '=', $numeroIdentification],['id','!=',$idCompte]])->get()) == 0 ){
                return true;
            }
            //Sinon il est invalide.
            else{
                return false;
            }
        },"Ce numéro d'employé est déjà utilisé. Veuillez en utiliser un autre.");

        Validator::extend('validerListeConferenciers', function ($field, $value, $parameters, $validator) {
            //Obtient la liste de conférencier
            $listeConferenciers = explode(";",array_get($validator->getData(), $parameters[0]));
            foreach ($listeConferenciers as $idConferencier) {
              if(count(DB::table(Constantes::$TABLE_ANIMATEURS)->where('id','=',$idConferencier)->get()) == 0){
                return false;
              }
            }

            return true;
        },"L'un des conférenciers que vous avez sélectionné n'existe pas dans la base de données.");
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}

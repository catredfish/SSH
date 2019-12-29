<?php

namespace App\Validation;

use Illuminate\Foundation\Http\FormRequest;

class ModelValidation extends FormRequest {

    //Règles de validation d'un compte
    public static function CompteVisiteurValidation() {
        return [
            'Nom' => 'required|min:1',
            'Prenom' => 'required|min:1',
            'Courriel' => 'required|email||validerCourriel:Courriel',
            'MotDePasse' => ['required', 'regex:/^(?=.*[A-Z\x{00C0}-\x{00DC}])(?=.*[\d])[A-Z\x{00C0}-\x{00DC}a-z\x{00E0}-\x{00FC}\d@$!%*?&]{5,16}$/'],
            'ConfirmationMotDePasse' => 'same:MotDePasse',
            'typeConnexion' => 'exists:type_de_connexions,id'
        ];
    }

    //Messages d'erreur d'un compte
    public static function CompteVisiteurValidationMessages() {
        return [
            'Nom.required' => "Le nom est requis.",
            'Prenom.required' => "Le prénom est requis.",
            'Courriel.required' => "Le courriel est requis.",
            'Courriel.email' => "Le format du courriel est non valide.",
            'MotDePasse.required' => 'Le mot de passe est requis.',
            'MotDePasse.regex' => "Le mot de passe doit contenir de 5 à 16 caractères et doit comprendre une lettre majuscule ainsi qu'un nombre.",
            'ConfirmationMotDePasse.same' => 'Le mot de passe et la confirmation du mot de passe ne sont pas identiques.',
            'typeConnexion.exists' => 'Le type de compte est non valide.'
        ];
    }

    public static function CompteEtudiantValidation() {
        return [
            'Nom' => 'required|min:1',
            'Prenom' => 'required|min:1',
            'Courriel' => 'required|email||validerCourriel:Courriel',
            'programme' => 'validerProgramme:programme',
            'NumeroIdentification' => 'required|size:7|validerNumeroEtudiant:NumeroIdentification',
            'MotDePasse' => ['required', 'regex:/^(?=.*[A-Z\x{00C0}-\x{00DC}])(?=.*[\d])[A-Z\x{00C0}-\x{00DC}a-z\x{00E0}-\x{00FC}\d@$!%*?&]{5,16}$/'],
            'ConfirmationMotDePasse' => 'same:MotDePasse',
            'typeConnexion' => 'exists:type_de_connexions,id'
        ];
    }

    //Messages d'erreur d'un compte
    public static function CompteEtudiantValidationMessages() {
        return [
            'Nom.required' => "Le nom est requis.",
            'Prenom.required' => "Le prénom est requis.",
            'Courriel.required' => "Le courriel est requis.",
            'Courriel.email' => "Le format du courriel est non valide.",
            'NumeroIdentification.required' => "Le numéro d'étudiant est requis.",
            'NumeroIdentification.size' => "Le numéro d'étudiant doit contenir sept chiffres.",
            'MotDePasse.required' => 'Le mot de passe est requis.',
            'MotDePasse.regex' => "Le mot de passe doit contenir de 5 à 16 caractères et doit comprendre une lettre majuscule ainsi qu'un nombre.",
            'ConfirmationMotDePasse.same' => 'Le mot de passe et la confirmation du mot de passe ne sont pas identiques.',
            'typeConnexion.exists' => 'Le type de compte est non valide.'
        ];
    }

    public static function CompteEmployeValidation() {
        return [
          'Nom' => 'required|min:1',
          'Prenom' => 'required|min:1',
          'Courriel' => 'required|email||validerCourriel:Courriel',
          'programme' => 'validerProgramme:programme',
          'NumeroIdentification' => 'required|size:5|validerNumeroEtudiant:NumeroIdentification',
          'MotDePasse' => ['required', 'regex:/^(?=.*[A-Z\x{00C0}-\x{00DC}])(?=.*[\d])[A-Z\x{00C0}-\x{00DC}a-z\x{00E0}-\x{00FC}\d@$!%*?&]{5,16}$/'],
          'ConfirmationMotDePasse' => 'same:MotDePasse',
          'typeConnexion' => 'exists:type_de_connexions,id'
        ];
    }

    //Messages d'erreur d'un compte
    public static function CompteEmployeValidationMessages() {
        return [
            'NumeroIdentification.required' => "Le numéro d'employé est requis.",
            'NumeroIdentification.size' => "Le numéro d'employé doit contenir cinq chiffres.",
            'Nom.required' => "Le nom est requis.",
            'Prenom.required' => "Le prénom est requis.",
            'Courriel.required' => "Le courriel est requis.",
            'Courriel.email' => "Le format du courriel est non valide.",
            'MotDePasse.required' => 'Le mot de passe est requis.',
            'MotDePasse.regex' => "Le mot de passe doit contenir de 5 à 16 caractères et doit comprendre une lettre majuscule ainsi qu'un nombre.",
            'ConfirmationMotDePasse.same' => 'Le mot de passe et la confirmation du mot de passe ne sont pas identiques.',
            'typeConnexion.exists' => 'Le type de compte est non valide.'
        ];
    }

    //Règles de validation d'un compte
    public static function ModifierCompteEtudiantValidation() {
        return [
            'Nom' => 'required|min:1',
            'Prenom' => 'required|min:1',
            'Courriel' => 'required|email||validerCourrielModifierCompte:Courriel,id',
            'programme' => 'validerProgramme:programme',
            'NumeroIdentification' => 'required|size:7|validerNumeroEtudiantModifierCompte:NumeroIdentification,id',
            'MotDePasse' => ['required', 'regex:/^(?=.*[A-Z\x{00C0}-\x{00DC}])(?=.*[\d])[A-Z\x{00C0}-\x{00DC}a-z\x{00E0}-\x{00FC}\d@$!%*?&]{5,16}$/'],
            'ConfirmationMotDePasse' => 'same:MotDePasse',
            'typeConnexion' => 'exists:type_de_connexions,id'
        ];
    }

    //Messages d'erreur d'un compte
    public static function ModifierCompteEtudiantValidationMessages() {
        return [
            'NumeroIdentification.required' => "Le numéro d'étudiant est requis.",
            'NumeroIdentification.size' => "Le numéro d'identification doit contenir sept chiffres.",
            'Nom.required' => "Le nom est requis.",
            'Prenom.required' => "Le prénom est requis.",
            'Courriel.required' => "Le courriel est requis.",
            'Courriel.email' => "Le format du courriel est non valide.",
            'MotDePasse.required' => 'Le mot de passe est requis.',
            'MotDePasse.regex' => "Le mot de passe doit contenir de 5 à 16 caractères et doit comprendre une lettre majuscule ainsi qu'un nombre.",
            'ConfirmationMotDePasse.same' => 'Le mot de passe et la confirmation du mot de passe ne sont pas identiques.',
            'typeConnexion.exists' => 'Le type de compte est non valide.',
        ];
    }

    //Règles de validation d'un compte
    public static function ModifierCompteEmployeValidation() {
        return [
            'Nom' => 'required|min:1',
            'Prenom' => 'required|min:1',
            'Courriel' => 'required|email||validerCourrielModifierCompte:Courriel,id',
            'programme' => 'validerProgramme:programme',
            'NumeroIdentification' => 'required|size:5|validerNumeroEmployeModifierCompte:NumeroIdentification,id',
            'MotDePasse' => ['required', 'regex:/^(?=.*[A-Z\x{00C0}-\x{00DC}])(?=.*[\d])[A-Z\x{00C0}-\x{00DC}a-z\x{00E0}-\x{00FC}\d@$!%*?&]{5,16}$/'],
            'ConfirmationMotDePasse' => 'same:MotDePasse',
            'typeConnexion' => 'exists:type_de_connexions,id',
            
        ];
    }

    //Messages d'erreur d'un compte
    public static function ModifierCompteEmployeValidationMessages() {
        return [
            'NumeroIdentification.required' => "Le numéro d'employé est requis.",
            'NumeroIdentification.size' => "Le numéro d'identification doit contenir sept chiffres.",
            'Nom.required' => "Le nom est requis.",
            'Prenom.required' => "Le prénom est requis.",
            'Courriel.required' => "Le courriel est requis.",
            'Courriel.email' => "Le format du courriel est non valide.",
            'MotDePasse.required' => 'Le mot de passe est requis.',
            'MotDePasse.regex' => "Le mot de passe doit contenir de 5 à 16 caractères et doit comprendre une lettre majuscule ainsi qu'un nombre.",
            'ConfirmationMotDePasse.same' => 'Le mot de passe et la confirmation du mot de passe ne sont pas identiques.',
            'typeConnexion.exists' => 'Le type de compte est non valide.',
        ];
    }

    //Règles de validation d'un compte
    public static function ModifierCompteVisiteurValidation() {
        return [
            'Nom' => 'required|min:1',
            'Prenom' => 'required|min:1',
            'Courriel' => 'required|email||validerCourrielModifierCompte:Courriel,id',
            'MotDePasse' => ['required', 'regex:/^(?=.*[A-Z\x{00C0}-\x{00DC}])(?=.*[\d])[A-Z\x{00C0}-\x{00DC}a-z\x{00E0}-\x{00FC}\d@$!%*?&]{5,16}$/'],
            'ConfirmationMotDePasse' => 'same:MotDePasse',
            'typeConnexion' => 'exists:type_de_connexions,id',
        ];
    }

    //Messages d'erreur d'un compte
    public static function ModifierCompteVisiteurValidationMessages() {
        return [
            'Nom.required' => "Le nom est requis.",
            'Prenom.required' => "Le prénom est requis.",
            'Courriel.required' => "Le courriel est requis.",
            'Courriel.email' => "Le format du courriel est non valide.",
            'MotDePasse.required' => 'Le mot de passe est requis.',
            'MotDePasse.regex' => "Le mot de passe doit contenir de 5 à 16 caractères et doit comprendre une lettre majuscule ainsi qu'un nombre.",
            'ConfirmationMotDePasse.same' => 'Le mot de passe et la confirmation du mot de passe ne sont pas identiques.',
            'typeConnexion.exists' => 'Le type de compte est non valide.',
        ];
    }

    //Règles de validation pour un atelier
    public static function AtelierValidation() {
        return [
            'Nom' => 'required|min:1',
            'listeConferenciers' => 'required|validerListeConferenciers:listeConferenciers',
            'Endroit' => 'required|min:1',
            'HeureDebut' => ['required', 'regex:/^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/'],
            'Duree' => 'required||validerDuree:Duree',
            'DateAtelier' => 'required|after:' . date("y-m-d"),
            'NombreDePlace' => 'required|gt:0',
            'idCampus' => ['required', 'regex:/^[1-3]$/']
        ];
    }

    //Messages d'erreur pour un atelier
    public static function AtelierValidationMessages() {
        return [
            'Nom.required' => "Le nom est requis.",
            'Endroit.required' => "Le local de l'atelier est requis.",
            'HeureDebut.required' => "L'heure de début de l'atelier est requis.",
            'Duree.required' => "La durée de l'atelier est requise.",
            'DateAtelier.required' => "La date où l'atelier se déroulera est requise.",
            'DateAtelier.after' => "La date choisie doit être supérieure à la date d'aujourd'hui.",
            "NombreDePlace.required" => "Le nombre de participants maximal pour l'atelier est requis.",
            'idCampus.required' => "Le ou les campus où l'atelier se déroulera sont requis.",
            "HeureDebut.regex" => "Le format de l'heure de début de l'atelier est non valide.",
            "NombreDePlace.gt" => "Le nombre de places doit être supérieur à zéro.",
            "idCampus.regex" => "Le numéro de campus est non valide.",
            "listeConferenciers.required" => "Vous devez sélectionner un conférencier."
        ];
    }

    //Règles de validation pour la connexion
    public static function ConnexionValidationCourriel() {
        return [
            'log' => 'required|email|exists:comptes,courriel',
            'MotDePasse' => 'required|validerConnexion:log,MotDePasse,typeConnexion'
        ];
    }

    //Messages d'erreur pour la connexion
    public static function ConnexionValidationCourrielMessages() {
        return [
            'log.required' => "Le courriel est requis.",
            'log.email' => "Le format du courriel est non valide.",
            'MotDePasse.required' => 'Le mot de passe est requis.',
            'log.exists' => 'Le courriel est non valide.',
        ];
    }

    public static function ConnexionValidationEtudiant() {
        return [
            'log' => 'required|size:7|exists:comptes,NumeroIdentification',
            'MotDePasse' => 'required|validerConnexion:log,MotDePasse,typeConnexion'
        ];
    }

    //Messages d'erreur pour la connexion
    public static function ConnexionValidationEtudiantMessages() {
        return [
            'log.size' => "Le numéro d'étudiant doit contenir sept chiffres.",
            'log.required' => "Le numéro d'étudiant est requis.",
            'MotDePasse.required' => 'Le mot de passe est requis.',
            'log.exists' => "Le numéro d'étudiant est non valide.",
        ];
    }

    public static function ConnexionValidationEmploye() {
        return [
            'log' => 'required|size:5|exists:comptes,NumeroIdentification',
            'MotDePasse' => 'required|validerConnexion:log,MotDePasse,typeConnexion'
        ];
    }

    //Messages d'erreur pour la connexion
    public static function ConnexionValidationEmployeMessages() {
        return [
            'log.size' => "Le numéro d'employé doit contenir cinq chiffres.",
            'log.required' => "Le numéro d'employé est requis.",
            'MotDePasse.required' => 'Le mot de passe est requis.',
            'log.exists' => "Le numéro d'employé est non valide.",
        ];
    }

    //Règles de validation pour un conférencier
    public static function ConferencierValidation() {
        return [
            'Nom' => 'required|min:1',
            'Prenom' => 'required|min:1',
            'Courriel' => 'email||validerCourrielConferencier:Courriel',
            'Expertise' => 'required|min:1',
        ];
    }
    //Messages d'erreur pour un conférencier
    public static function ConferencierValidationMessages() {
        return [
            'Nom.required' => "Le nom est requis.",
            'Prenom.required' => "La prénom est requis.",
            'Courriel.email' => "Le format du courriel est non valide.",
            'Expertise.required' => "L'expertise est requise.",
        ];
    }


    //Règles de validation pour une modification de conférencier
    public static function ModifierConferencierValidation() {
        return [
            'Nom' => 'required|min:1',
            'Prenom' => 'required|min:1',
            'Courriel' => 'email||validerModificationCourrielConferencier:Courriel,Id',
            'Expertise' => 'required|min:1',
        ];
    }
    //Messages d'erreur pour une modification de conférencier
    public static function ModifierConferencierValidationMessages() {
        return [
            'Nom.required' => "Le nom est requis.",
            'Prenom.required' => "La prénom est requis.",
            'Courriel.email' => "Le format du courriel est non valide.",
            'Expertise.required' => "L'expertise est requise.",
        ];
    }
}
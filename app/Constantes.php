<?php
namespace App;

class Constantes
{
    //Session
    public static $ID_COMPTE = "idCompte";
    public static $ID_TYPE_DE_COMPTE = "idTypeDeCompte";
    public static $ID_TYPE_DE_CONNEXION = "idTypeConnexion";
    public static $ID_SUPER_ADMINISTRATEUR = 3;
    public static $ID_ADMINISTRATEUR = 2;
    public static $ID_UTILISATEUR = 1;

    // Type de connexion
    public static $ID_ELEVE= 1;
    public static $ID_EMPLOYE = 2;
    public static $ID_VISITEUR = 3;

    // Actif ou inactif
    public static $ID_ACTIF = 1;
    public static $ID_INACTIF = 0;

    //Middleware
    public static $MIDDLEWARE_SUPER_ADMINISTRATEUR = "autorisationSuperAdministrateur";
    public static $MIDDLEWARE_ADMINISTRATEUR = "autorisationAdministrateur";
    public static $MIDDLEWARE_UTILISATEUR = "autorisationUtilisateur";

    //Table
    public static $TABLE_CONFERENCIERS = "animateurs";
    public static $TABLE_PROGRAMME = "programmes";
    public static $TABLE_ATELIERS = "ateliers";
    public static $TABLE_CAMPUSES = "campuses";
    public static $TABLE_COMPTES = "comptes";
    public static $TABLE_LIEN_ATELIER_ANIMATEURS = "lien_atelier_animateurs";
    public static $TABLE_LIEN_ATELIER_COMPTES = "lien_atelier_comptes";
    public static $TABLE_LIEN_LISTE_ATTENTES = "liste_attentes";
    public static $TYPE_DE_COMPTES = "type_de_comptes";
    public static $TABLE_TYPE_DE_CONNEXIONS = "type_de_connexions";
    public static $TABLE_ANIMATEURS = "animateurs";

    //Attributs des tables

    //lien_atelier_animateurs
    public static $COLUMN_ID_ATELIER_LIEN_ATELIER_ANIMATEUR = "idAtelierLienAtelierAnimateur";
    public static $COLUMN_ID_ANIMATEUR_LIEN_ATELIER_ANIMATEUR = "idAnimateurLienAtelierAnimateur";

    //Lien_Atelier_Compte
    public static $COLUMN_ID_COMPTE_LIEN_ATELIER_COMPTE = "idCompteLienAtelierCompte";
    public static $COLUMN_ID_ATELIER_LIEN_ATELIER_COMPTE = "idAtelierLienAtelierCompte";

    //Liste d'attentes
    public static $COLUMN_ID_ATELIER_LISTE_ATTENTES = "idAtelierListeAttentes";
    public static $COLUMN_ID_COMPTE_LISTE_ATTENTES = "idCompteListeAttentes";

    //Comptes
    public static $COLUMN_ID = "id";
    public static $COLUMN_NUMERO_IDENTIFICATION = "NumeroIdentification";
    public static $COLUMN_NOM = "Nom";
    public static $COLUMN_PRENOM = "Prenom";
    public static $COLUMN_TYPE_DE_COMPTE = "idTypeCompte";
    public static $COLUMN_ID_TYPE_DE_CONNEXION = "idTypeConnexion";


    // Conferenciers
    public static $COLUMN_ACTIF = "Actif";

    //Ateliers
    public static $COLUMN_ID_ATELIERS = "id";
    public static $COLUMN_NOM_ATELIERS = "Nom";
    public static $COLUMN_ENDROIT_ATELIERS = "Endroit";
    public static $COLUMN_HEURE_DEBUT_ATELIERS = "HeureDebut";
    public static $COLUMN_DUREE_ATELIERS = "Duree";
    public static $COLUMN_DESCRIPTION_ATELIERS = "Description";
    public static $COLUMN_DATE_ATELIER_ATELIERS = "DateAtelier";
    public static $COLUMN_NOMBRE_DE_PLACE_ATELIERS = "NombreDePlace";
    public static $COLUMN_ID_CAMPUS_ATELIERS = "idCampus";
    public static $COLUMN_ID_Programme_ATELIERS = "idProgramme";

    //Programme
    public static $COLUMN_ID_PROGRAMME = "id";
    public static $COLUMN_NOM_PROGRAMME = "Nom";
    public static $COLUMN_ID_TYPE_PROGRAMME = "idTypeProgramme";
    public static $COLUMN_ID_CATEGORIES_PROGRAMME = "idCategoriesProgramme";

    //Type de connexions
    public static $COLUMN_ID_TYPE_DE_CONNEXIONS = "id";
    public static $COLUMN_NOM_TYPE_DE_CONNEXIONS = "Nom";
}

<?php
namespace App;

class Constantes
{
    //Session
    public static $ID_COMPTE = "idCompte";
    public static $ID_TYPE_DE_COMPTE = "idTypeDeCompte";
    public static $ID_ADMINISTRATEUR = 2;
    public static $ID_UTILISATEUR = 1;

    //Middleware
    public static $MIDDLEWARE_ADMINISTRATEUR = "autorisationAdministrateur";
    public static $MIDDLEWARE_UTILISATEUR = "autorisationUtilisateur";

    //Table
    public static $TABLE_CONFERENCIERS = "animateurs";
    public static $TABLE_ATELIERS = "ateliers";
    public static $TABLE_CAMPUSES = "campuses";
    public static $TABLE_COMPTES = "comptes";
    public static $TABLE_LIEN_ATELIER_ANIMATEURS = "lien_atelier_animateurs";
    public static $TABLE_LIEN_ATELIER_COMPTES = "lien_atelier_comptes";
    public static $TABLE_LIEN_LISTE_ATTENTES = "liste_attentes";
    public static $TYPE_DE_COMPTES = "type_de_comptes";

    //Attributs des tables

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

    // Conferenciers
    public static $COLUMN_ACTIF = "Actif";
}

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* Super administrateur */
Route::get('/ListeAdministrateurs', 'SuperAdministrateurController@VoirListeAdministrateurs')->name('ListeAdministrateurs');
Route::post('/RetrograderAdministrateur', 'SuperAdministrateurController@RetrograderAdministrateur');
Route::post('/PromouvoirUtilisateur', 'SuperAdministrateurController@PromouvoirUtilisateur');
Route::post('/ActiverCompte', 'SuperAdministrateurController@ActiverCompte');
Route::post('/DesactiverCompte', 'SuperAdministrateurController@DesactiverCompte');

/* Administrateur */
Route::get('/CreationAtelier','AdministrateurController@VoirCreerAtelier')->name('VoirCreerAtelier');
Route::post('/Atelier/CreerAtelier','AdministrateurController@CreerAtelier')->name('CreerAtelier');
Route::get('/AnnulationAtelier', 'AdministrateurController@VoirListeAnnulationAtelier')->name('AnnulationAtelier');
Route::get('/VoirAnnulerAtelier', 'AdministrateurController@VoirAnnulerAtelier');
Route::post('/AnnulationAtelier/Annulation', 'AdministrateurController@AnnulationAtelier');
Route::get('/EnvoyerRappel', 'AdministrateurController@VoirEnvoyerRappel');
Route::post('/EnvoyerRappel/EnvoyerRappel', 'AdministrateurController@EnvoyerRappel');
Route::get('/CreationConferencier', 'AdministrateurController@VoirCreerConferencier');
Route::post('/CreerConferencier', 'AdministrateurController@CreerConferencier');
Route::get('/ErreursCreationConferencier', 'AdministrateurController@VoirErreursCreerConferencier')->name('VoirErreursCreerConferencier');
Route::get('/ModificationConferencier', 'AdministrateurController@VoirModifierConferencier');
Route::post('/ModifierConferencier', 'AdministrateurController@ModifierConferencier');
Route::get('/ErreursModificationConferencier', 'AdministrateurController@VoirErreursModifierConferencier')->name('VoirErreursModifierConferencier');
Route::get('/GestionAteliers','AdministrateurController@VoirGestionAteliers')->name('GestionAteliers');
Route::get('/ModifierAtelier','AdministrateurController@VoirModifierAtelier')->name('VoirModifierAtelier');
Route::post('/ModifierAtelier/Modifier','AdministrateurController@ModifierAtelier');
Route::get('/ConfirmerSuppressionConferencier','AdministrateurController@VoirSupprimerConferencier');
Route::post('/SupprimerConferencier','AdministrateurController@SupprimerConferencier');
Route::get('/ImprimerListePresence','AdministrateurController@ImprimerListePresence');
Route::post('/GestionDesAteliers','AdministrateurController@VoirGestionAteliers')->name('GestionDesAteliers');
Route::post('/EnvoyerRappelGenerique', 'AdministrateurController@EnvoyerRappelGenerique');
Route::post('/EnvoyerRappelSpecifique','AdministrateurController@EnvoyerRappelSpecifique');
Route::post('/VoirEnvoyerRappelSpecifique','AdministrateurController@VoirEnvoyerRappelSpecifique');
Route::post('/VoirEnvoyerRappelGenerique','AdministrateurController@VoirEnvoyerRappelGenerique');

/*tout les types d'utilisateurs*/
Route::post('/AfficherDescriptionAtelier','UtilisateurController@AfficherDescriptionAtelier');
Route::get('/VoirMessageErreur','VisiteurController@VoirMessageErreur')->name('MessageErreur');

/* Utilisateur */
Route::get('/Formation', 'UtilisateurController@VoirFormation');
Route::get('/ListeAteliers', 'UtilisateurController@VoirListeAteliers')->name('ListeAteliers');
Route::post('/ListeParticipants', 'UtilisateurController@VoirListeParticipants');
Route::get('/ListeConferenciers', 'UtilisateurController@VoirListeConferenciers')->name('ListeConferenciers');
Route::get('/VoirConferencier','UtilisateurController@VoirConferencier');
Route::get('/VoirConferencierDescriptionAtelier','UtilisateurController@VoirConferencierDescriptionAtelier');
Route::get('/VoirDescriptionAtelier','UtilisateurController@voirDescriptionAtelier');
Route::post('/VoirDescriptionConflit', 'UtilisateurController@VoirDescriptionConflit');
Route::post('/ConfirmerInscriptionAtelier', 'UtilisateurController@VoirInscriptionAtelier');
Route::post('/ConfirmerDesinscriptionAtelier', 'UtilisateurController@VoirDesinscriptionAtelier');
Route::post('/ConfirmerInscriptionListeAttentes', 'UtilisateurController@VoirInscriptionListeAttentes');
Route::post('/ConfirmerDesinscriptionListeAttentes', 'UtilisateurController@VoirDesinscriptionListeAttentes');

//atelier
Route::post('/InscriptionAtelier','UtilisateurController@InscriptionAtelier');

//Liste d'attentes
Route::post('/InscriptionListeAttentes','UtilisateurController@InscriptionListeAttentes');

//Compte
Route::post('/ModifierCompte/Modification','UtilisateurController@ModifierCompte');
Route::get('/ModifierCompte', 'UtilisateurController@VoirModifierCompte')->name("VoirModifierCompte");
Route::get('/Compte', 'UtilisateurController@VoirCompte');
Route::post('employees/{id}', ['as' => 'employees', 'uses' => 'mot@getemployee']);

/* Visiteur */
Route::get('/Connexion', 'VisiteurController@VoirConnexion')->name('Connexion');
Route::get('/Deconnexion', 'VisiteurController@Deconnexion')->name('Deconnexion');
Route::get('/Inscription', 'VisiteurController@VoirInscription')->name("Inscription");
Route::get('/Accueil', 'VisiteurController@VoirAccueil')->name('voirAccueil');
Route::get('/', 'VisiteurController@VoirAccueil');

/* visiteur Formulaires d'inscription */
Route::get('/FormulaireInscription','VisiteurController@VoirFormulaireInscription');
Route::get('/Form', function () {
    return view('Shared/Form_Layout');
});
Route::post('/Inscription/CreerCompte', "VisiteurController@CreerCompte");
Route::post('/Connexion/Connexion', "VisiteurController@Connexion");
Route::get('/Email', 'UtilisateurController@EnvoyerRappelListeAttentes');

//Début - Test courriel par Samir
Route::get('send', 'UtilisateurController@send');
//Fin - Test courriel par Samir

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Constantes;
use App\Validation\ModelValidation;
use App\Model\VoirListeAdministrateursViewModel;
use Illuminate\Support\Facades\DB;
use Mail;
use Illuminate\Support\Facades\Input;
use Session;

class SuperAdministrateurController extends Controller {

    public function __construct(Request $request)
    {
        //Vérifie si l'utilisateur est un administrateur
        $this->middleware(Constantes::$MIDDLEWARE_SUPER_ADMINISTRATEUR);
    }

    // Affiche la liste des comptes
    public function VoirListeAdministrateurs(){
        // Crée le modèle pour la vue
        $model = new VoirListeAdministrateursViewModel();

        // Spécifie l'onglet sélectionné si besoin est
        if(Input::has('ongletChoisi'))
        {
            $model->setOngletSelectionne(Input::get('ongletChoisi'));
        }
        else if(Session::has('ongletChoisi')){
            $model->setOngletSelectionne(Session::get('ongletChoisi'));
        }

        // Génère la liste des comptes
        $model->GenererListe();

        // Retourne la vue avec un modèle
        return view('SuperAdministrateur/VoirListeAdministrateurs')->with('model', $model);
    }

    // Permet de rétrograder un administrateur
    public function RetrograderAdministrateur(Request $request){

        // Rétrograde l'administrateur sélectionné
        DB::table(CONSTANTES::$TABLE_COMPTES)->where(CONSTANTES::$COLUMN_ID, $request->id)
            ->update([
                'idTypeCompte' => $request->idTypeCompte,
            ]);

        // Si l'action a fonctionné, retourne un message de succès
        return redirect()->route("ListeAdministrateurs")->with( 'ongletChoisi', $request->ongletChoisi);
    }

    // Permet de promouvoir un utilisateur
    public function PromouvoirUtilisateur(Request $request){

        // Pormouvoie l'utilisateur sélectionné
        DB::table(CONSTANTES::$TABLE_COMPTES)->where(CONSTANTES::$COLUMN_ID, $request->id)
            ->update([
                'idTypeCompte' => $request->idTypeCompte,
            ]);

        // Si l'action a fonctionné, retourne un message de succès
        return redirect()->route("ListeAdministrateurs")->with( 'ongletChoisi', $request->ongletChoisi);
    }

    // Permet d'activer un compte
    public function ActiverCompte(Request $request){

        // Active le compte
        DB::table(CONSTANTES::$TABLE_COMPTES)->where(CONSTANTES::$COLUMN_ID, $request->id)
            ->update([
                'Actif' => $request->Actif,
            ]);

        // Si l'action a fonctionné, retourne un message de succès
        return redirect()->route("ListeAdministrateurs")->with( 'ongletChoisi', $request->ongletChoisi);
    }

    // Permet de désactiver un compte
    public function DesactiverCompte(Request $request){

        // Désactive le compte
        DB::table(CONSTANTES::$TABLE_COMPTES)->where(CONSTANTES::$COLUMN_ID, $request->id)
            ->update([
                'Actif' => $request->Actif,
            ]);

        // Si l'action a fonctionné, retourne un message de succès
        return redirect()->route("ListeAdministrateurs")->with( 'ongletChoisi', $request->ongletChoisi);
    }
}
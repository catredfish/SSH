<?php
/**
 * Created by PhpStorm.
 * User: Thulium_Selenium
 * Date: 2019-02-11
 * Time: 4:20 PM
 */

namespace App\Http\Middleware;

use Closure;
use App\Constantes;

class AutorisationSuperAdministrateur
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        //Extrait les paramètres de la requête et de la session
        $typeDeCompte = session()->get(Constantes::$ID_TYPE_DE_COMPTE);
        //Vérifie si l'utilisateur est un Super Administrateur
        if((int)$typeDeCompte === Constantes::$ID_SUPER_ADMINISTRATEUR){
            //Si oui, continue
            return $next($request);
        }
        else {
            
            //Sinon retourne un message d'erreur
            return redirect()->route('MessageErreur');
        }
    }
}

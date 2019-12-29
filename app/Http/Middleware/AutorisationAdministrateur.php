<?php

namespace App\Http\Middleware;

use Closure;
use App\Constantes;

class AutorisationAdministrateur
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

      //Vérifie si l'utilisateur est un Administrateur
      if($typeDeCompte >= 2){
        //Si oui, continue
        return $next($request);
      }
      else {
        //Sinon retourne un message d'erreur
        return redirect()->route('MessageErreur');
      }
    }
}

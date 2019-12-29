<?php

namespace App\Http\Middleware;

use Closure;
use App\Constantes;

class AutorisationUtilisateur
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

       //Vérifie si l'usager est un administrateur ou bien un utilisateur
       if($typeDeCompte >= 1){
         //Si oui, continue
         return $next($request);
       }
       else {
         //Sinon retourne un message d'erreur
         return redirect()->route('MessageErreur');
       }
     }
}

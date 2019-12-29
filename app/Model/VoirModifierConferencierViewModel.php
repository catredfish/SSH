<?php
/**
 * Created by PhpStorm.
 * User: Thulium_Selenium
 * Date: 2019-02-03
 * Time: 6:02 PM
 */

namespace App\Model;
use Illuminate\Support\Facades\DB;
use App\Constantes;
use App\animateur;

class VoirModifierConferencierViewModel
{
    //Propriété
    private $model;

    //Constructeur
    public function __construct($Id) {

        // Obtient le conférencier
        $this -> model = DB::table(CONSTANTES::$TABLE_CONFERENCIERS)->where(CONSTANTES::$COLUMN_ID, '=', $Id)->get();

        //Vérifie si aucun conférencier n'a été trouvé
        if(count($this -> model) == 0){

            //Si tel est le cas, assigne le modèle comme étant null
            $this -> model = new animateur;
        }

        //Si un conférencier a été trouvé, l'assigne au modèle
        else{
            $this -> model = $this ->model[0];
        }
    }

    //Accesseur
    public function getConferencier(){
        return $this->model;
    }
}
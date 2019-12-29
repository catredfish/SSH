


  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="titreModalModifierCreer" class="modal-title">Modifier un atelier</h4>
        <button type="button" class="close" data-dismiss="modal" onclick="supprimerRecreerModal()">&times;</button>
      </div>
      <div class="modal-body" id="contenuModalModifierAtelier">
        <link rel="stylesheet" type="text/css" href="css/Administrateur/VoirModifierAtelier.css">
        <div class="col-md-12">
            <div class="card card-modifier">
                <form id="formulaire-modifier-atelier">
                    @csrf
                    <div id="contact-form" class="form-container-modifier" data-form-container>
                        <div class="row">
                            <table id="tableauErreurs">
                                @foreach ($errors->all() as $message)
                                <tr>
                                    <td align="left"><label class="erreur">{{$message}}</label></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="input-container">
                            <div class="row">
                                <span class="req-input" >
                                    <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer le nom de l'atelier."> </span>
                                    <input id="Nom" class="modifierAtelier-input" type="text" name="Nom" value='<?php if(is_null(Session::get('isOld'))){echo $model->getAtelier()->Nom;} else{echo old('Nom');}?>' data-min-length="1" placeholder="Nom">
                                </span>
                            </div>
                            <div class="row">
                              <span id="spanConferencier" class="req-input">
                                  <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez choisir le ou les conférenciers."> </span>
                                  <input hidden="hidden" id="liste-conferenciers" name="listeConferenciers" value="{{old('listeConferenciers')}}">
                                  <div class="dropdown dropdown-conferencier">
                                    <button id="bouton-programme" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">Veuillez choisir le ou les conférenciers.</button>
                                    <ul class="dropdown-menu">
                                      <li class="dropdown-submenu">
                                        <!-- initialise une liste de id pour les conferenciers Selectionnes -->
                                        <?php
                                        $listeIdsConferenciersSelectionnes = array();
                                        foreach ($model->getListeConferenciersSelectionnes() as $conferencier) {
                                            $listeIdsConferenciersSelectionnes[] = $conferencier->id;
                                        }
                                        ?>
                                        <!-- pour chaque conférencier dans la liste -->
                                        @foreach($model->getListeConferenciers() as $conferencier)
                                        <!-- Si le conférencier avait été sélectionné auparavant, le sélectionne -->
                                        @if(!is_null(old('listeConferenciers')))
                                        <input <?php if(in_array($conferencier->id,explode(";",old('listeConferenciers')))){echo "checked";}?> class="input-conferencier" type="checkbox" value="{{$conferencier->id}}">{{$conferencier->Prenom}} {{$conferencier->Nom}}<br>
                                        @else
                                        <input <?php if(in_array($conferencier->id,$listeIdsConferenciersSelectionnes)){echo "checked";}?> class="input-conferencier" type="checkbox" value="{{$conferencier->id}}">{{$conferencier->Prenom}} {{$conferencier->Nom}}<br>
                                        @endif
                                        @endforeach
                                      </li>
                                    </ul>
                                  </div>
                              </span>
                            </div>
                            <div class="row">
                                <span class="req-input" >
                                    <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer le nom de l'endroit où se déroulera l'activité."> </span>
                                    <input id="Endroit" class="modifierAtelier-input" type="text" name="Endroit" value='<?php if(is_null(Session::get('isOld'))){echo $model->getAtelier()->Endroit;} else{echo old('Endroit');}?>' data-min-length="1" placeholder="Local">
                                </span>
                            </div>
                            <div class="row">
                                <span class="req-input" >
                                    <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer l'heure à laquelle l'activité débutera."> </span>
                                    <input id="HeureDebut" class="modifierAtelier-input" type="time" name="HeureDebut" value='<?php if(is_null(Session::get('isOld'))){echo $model->getAtelier()->HeureDebut;} else{echo old('HeureDebut');}?>' data-min-length="1" placeholder="Heure de début">
                                </span>
                            </div>
                            <div class="row">
                                <span id="duree" class="req-input" >
                                    <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer la durée de l'activité en heure."> </span>
                                    <input id="Duree" class="modifierAtelier-input" type="text" name="Duree" value='<?php if(is_null(Session::get('isOld'))){echo $model->getAtelier()->Duree;} else{echo old('Duree');}?>' data-min-length="1" placeholder="Durée">
                                </span>
                            </div>
                            <div class="row">
                                <span id="description" class="req-input" >
                                    <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer la description de l'atelier."> </span>
                                    <textarea id="Description" type="text" name='Description' maxlength="10000" placeholder="Description" rows="10"><?php if(is_null(Session::get('isOld'))){echo $model->getAtelier()->Description;} else{echo old('Description');}?></textarea>
                                </span>
                            </div>
                            <div class="row">
                                <span class="req-input" >
                                    <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer la date où se déroulera l'atelier."> </span>
                                    <input id="DateAtelier" class="modifierAtelier-input" type="date" name="DateAtelier" value='<?php if(is_null(Session::get('isOld'))){echo $model->getAtelier()->DateAtelier;} else{echo old('DateAtelier');}?>' placeholder="Date">
                                </span>
                            </div>
                            <div class="row">
                                <span class="req-input" >
                                    <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer le nombre maximal de participants."> </span>
                                    <input id='nombreDePlaces' type="number" name="NombreDePlace" value='<?php if(is_null(Session::get('isOld'))){echo $model->getAtelier()->NombreDePlace;} else{echo old('NombreDePlace');}?>' min="1" data-min-length="1" placeholder="Nombre de places disponibles">
                                </span>
                            </div>
                            <div class="row">
                                <span class="req-input" >
                                    <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez sélectionner le ou les campus où se déroulera l'atelier."> </span>
                                    <select id="selectCampus" name="idCampus">
                                        <option value="1" <?php if((old('idCampus')?:$model->getAtelier()->idCampus) == 1){echo 'selected = "seleted"';} ?>>Tous les campus</option>
                                        <option value="2" <?php if((old('idCampus')?:$model->getAtelier()->idCampus) == 2){echo 'selected = "seleted"';} ?>>Gabrielle-Roy</option>
                                        <option value="3" <?php if((old('idCampus')?:$model->getAtelier()->idCampus) == 3){echo 'selected = "seleted"';} ?>>Félix-Leclerc</option>
                                    </select>
                                </span>
                            </div>
                            <div class="row submit-row">
                                <input hidden="hidden" id="idAtelier" name="idAtelier" value= "<?php if(is_null(Session::get('isOld'))){echo $model->getAtelier()->id;} else{echo old('idAtelier');}?>">
                                <button type="button" onclick="modifierAtelier()" class="btn btn-block submit-form">Soumettre</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <input id="idAteliermodalModifierAtelier" name="idAtelier" value="0" hidden />
        <button type="button" class="btn btn-danger"  data-dismiss="modal" onclick="supprimerRecreerModal()">Fermer</button>
      </div>
    </div>
  </div>
  <script src="js/Administrateur/VoirModifierAtelier.js"></script>

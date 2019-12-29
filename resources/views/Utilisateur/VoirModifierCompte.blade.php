@extends ('Shared/Master_Layout')

@section ('styles')
<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Utilisateur/VoirModifierCompte.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection

@section ('content')
<!-- Contenu -->
<div class="col-md-12">
    <div class="card">
        <form action="/ModifierCompte/Modification" method="post">
            @csrf
            <div id="contact-form" class="form-container" data-form-container>
                <div class="row">
                    <div class="form-title">
                        <div id="titre">Modifier votre compte</div>
                    </div>
                </div>
                <div class="input-container">
                    <div class="row">
                            <table id="tableauErreurs">
                                @foreach ($errors->all() as $message)
                                <tr>
                                    <td align="left"><label class="erreur">{{$message}}</label></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="row">
                        <h4>Informations</h4>
                        </div>
                        <div class="row">
                            <span class="req-input" >
                                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer votre nom."> </span>
                                <input type="text" name="Nom" value='<?php if(is_null(Session::get('isOld'))){echo $model->getCompte()->Nom;} else{echo old('Nom');}?>' data-min-length="1" placeholder="Nom">
                            </span>
                        </div>
                        <div class="row">
                            <span class="req-input" >
                                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer votre prénom."> </span>
                                <input type="text" name="Prenom" value='<?php if(is_null(Session::get('isOld'))){echo $model->getCompte()->Prenom;} else{echo old('Prenom');}?>' data-min-length="1" placeholder="Prénom">
                            </span>
                        </div>
                        @if ($model->getCompte()->idTypeConnexion == 1 || $model->getCompte()->idTypeConnexion == 2)
                        <div class="row">
                            <span class="req-input">
                                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer votre courriel."> </span>
                                <input type="email" name="Courriel" value='<?php if(is_null(Session::get('isOld'))){echo $model->getCompte()->Courriel;} else{echo old('Courriel');}?>' placeholder="Courriel">
                            </span>
                        </div>
                        <div class="row">
                          <span class="req-input">
                              <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez choisir un programme d'études."> </span>
                              <input type="number" data-connexionType = "programme" id="input-programme" hidden="hidden" name="programme" value =<?php
                              //Si aucune programme n'a été sélectionné
                              if(!is_null(old('programme')) || !is_null($model->getTypeDeProgramme()->id)){echo old('programme')?:$model->getTypeDeProgramme()->id;} else{ echo 29;} ?>>
                              <div class="dropdown dropdown-programme">
                                <button id="bouton-programme" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                <?php if(!is_null(old('programme')) || !is_null($model->getTypeDeProgramme()->Nom)){
                                foreach ($model->getListeProgrammesTechniques() as $programmeTechnique) {
                                  if($programmeTechnique->id == (int)old('programme') || $programmeTechnique->id == $model->getTypeDeProgramme()->id){
                                    echo $programmeTechnique->Nom;
                                    break;
                                  }
                                }
                                foreach ($model->getListeProgrammesPreuniversitaires() as $programmePreuniversitaire) {
                                  if($programmePreuniversitaire->id == old('programme') || $programmePreuniversitaire->id == $model->getTypeDeProgramme()->id){
                                    echo $programmePreuniversitaire->Nom;
                                    break;
                                  }
                                }
                              } else{ echo "Sciences humaines";}?>
                              </button>
                                <ul class="dropdown-menu">
                                  <li class="dropdown-submenu">
                                    <a class="test" tabindex="-1" href="#">Programmes techniques <span class="caret"></span></a>
                                    <ul class="dropdown-menu listeProgrammes">
                                      @foreach($model-> getListeProgrammesTechniques() as $programmeTechnique)
                                      <li><a class ="btn btn-light btn-programme" onclick='choisirProgramme({{$programmeTechnique->id}},"{{$programmeTechnique->Nom}}")' tabindex="-1" href="#">{{$programmeTechnique->Nom}}</a></li>
                                      @endforeach
                                    </ul>
                                  </li>
                                  <li class="dropdown-submenu">
                                    <a class="test" tabindex="-1" href="#">Programmes préuniversitaires <span class="caret"></span></a>
                                    <ul class="dropdown-menu listeProgrammes">
                                      @foreach($model->getListeProgrammesPreuniversitaires() as $programmePreuniversitaire)
                                      <li><a class ="btn btn-light btn-programme" onclick='choisirProgramme({{$programmePreuniversitaire->id}},"{{$programmePreuniversitaire->Nom}}")' tabindex="-1" href="#">{{$programmePreuniversitaire->Nom}}</a></li>
                                      @endforeach
                                    </ul>
                                  </li>
                                  <li class="dropdown-submenu">
                                <a class ="btn btn-light btn-programme" onclick='choisirProgramme({{$model->getTremplinDec()->id}},"{{$model->getTremplinDec()->Nom}}")' tabindex="-1" href="#">{{$model->getTremplinDec()->Nom}}</a>
                              </li>
                                </ul>
                              </div>
                          </span>
                        </div>
                        @endif
                        <div class="row">
                        <h4>Connexion</h4>
                        </div>
                        @if ($model->getCompte()->idTypeConnexion == 1)
                        <div class="row">
                            <span class="req-input" >
                                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer votre numéro d'étudiant."> </span>
                                <input type="number" data-connexionType = "etudiant" name="NumeroIdentification" value='<?php if(is_null(Session::get('isOld'))){echo $model->getCompte()->NumeroIdentification;} else{echo old('NumeroIdentification');}?>' data-min-length="7" placeholder="Numéro d'étudiant à 7 chiffres">
                            </span>
                        </div>
                        @elseif ($model->getCompte()->idTypeConnexion == 2)
                        <div class="row">
                            <span class="req-input" >
                                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer votre numéro d'employé."> </span>
                                <input type="number" data-connexionType = "employe" name="NumeroIdentification" value='<?php if(is_null(Session::get('isOld'))){echo $model->getCompte()->NumeroIdentification;} else{echo old('NumeroIdentification');}?>' data-min-length="5" placeholder="Numéro d'employé à 5 chiffres">
                            </span>
                        </div>
                        @elseif ($model->getCompte()->idTypeConnexion == 3)
                        <div class="row">
                            <span class="req-input">
                                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer votre courriel."> </span>
                                <input type="email" name="Courriel" value='<?php if(is_null(Session::get('isOld'))){echo $model->getCompte()->Courriel;} else{echo old('Courriel');}?>' placeholder="Courriel">
                            </span>
                        </div>
                        @else
                        <div class="row">
                            <span class="req-input">
                                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer votre courriel."> </span>
                                <input type="email" name="Courriel" value='<?php if(is_null(Session::get('isOld'))){echo $model->getCompte()->Courriel;} else{echo old('Courriel');}?>' placeholder="Courriel">
                            </span>
                        </div>
                        @endif
                        <input name="typeConnexion" hidden="hidden" value='<?php if(is_null(Session::get('isOld'))){echo $model->getCompte()->idTypeConnexion;} else{echo old('typeConnexion');}?>'>
                        <div class="row">
                            <span class="req-input input-password">
                                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer un mot de passe contenant de 5 à 16 caractères et comprenant une lettre majuscule ainsi qu'un nombre."> </span>
                                <input type="password" name="MotDePasse" data-min-length="5" placeholder="Mot de passe">
                            </span>
                        </div>
                        <div class="row" id="confirmationMDP">
                            <span class="req-input confirm-password">
                                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer une confirmation de mot de passe qui soit identique au mot de passe."> </span>
                                <input type="password" name="ConfirmationMotDePasse" data-min-length="5" placeholder="Confirmation du mot de passe">
                            </span>
                        </div>
                    <div class="row submit-row">
                        <button type="submit" class="btn btn-block submit-form">Soumettre</button>
                    </div>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="js/Utilisateur/VoirModifierCompte.js"></script>

@endsection

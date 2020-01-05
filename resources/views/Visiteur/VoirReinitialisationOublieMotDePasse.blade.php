@extends ('Shared/Master_Layout')

@section ('styles')
<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Visiteur/VoirReinitialisationOublieMotDePasse.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection

@section ('content')
<!-- Contenu -->


<div class="col-md-12">
    <div class="card">
        <form action="ReinitialisationOublieMotDePasse/ReinitialisationOublieMotDePasse" method = "post">
            @csrf
            <div id="contact-form" class="form-container" data-form-container>
                <div class="row">
                    <div class="form-title">
                        <div id="titre">
                          Réinitialisation de mot de passe avec jeton
                        </div>
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
                        <span class="req-input">
                            <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer le courriel associé à votre compte."> </span>
                            <input disabled="disabled" type="email" value='<?php if(is_null(Session::get('isOld'))){echo $model->getCourriel();} else{echo old('Courriel');}?>' placeholder="Courriel">
                            <input hidden="hidden" name="Courriel" value='<?php if(is_null(Session::get('isOld'))){echo $model->getCourriel();} else{echo old('Courriel');}?>'>
                        </span>
                    </div>
                    <div class="row">
                            <span class="req-input input-password">
                                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer un nouveau mot de passe contenant de 5 à 16 caractères et comprenant une lettre majuscule ainsi qu'un nombre."> </span>
                                <input type="password" name="MotDePasse" data-min-length="5" placeholder="Nouveau mot de passe">
                            </span>
                        </div>
                        <div class="row" id="confirmationMDP">
                            <span class="req-input confirm-password">
                                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer une confirmation de mot de passe qui soit identique au mot de passe."> </span>
                                <input type="password" name="ConfirmationMotDePasse" data-min-length="5" placeholder="Confirmation du nouveau mot de passe">
                            </span>
                        </div>
                    <input hidden="hidden" name="Jeton" value="{{$model->getJeton()}}">
                    <div class="row submit-row">
                        <button type="submit" class="btn btn-block submit-form">Réinitialiser le mot de passe</button>
                </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal  -->
<div id="sectionPourModale">
  <div class="modal fade " id="modal" role="dialog">
  </div>
</div>


<!-- Scripts -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/Visiteur/VoirReinitialisationOublieMotDePasse.js"></script>

@endsection

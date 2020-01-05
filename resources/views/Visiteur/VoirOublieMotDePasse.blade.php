@extends ('Shared/Master_Layout')

@section ('styles')
<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Visiteur/VoirOublieMotDePasse.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection

@section ('content')
<!-- Contenu -->


<div class="col-md-12">
    <div class="card">
        <form action="/OublieMotDePasse/EnvoyerCourrielOublieMotDePasse" method = "post">
            @csrf
            <div id="contact-form" class="form-container" data-form-container>
                <div class="row">
                    <div class="form-title">
                        <div id="titre">
                          Réinitialiser le mot de passe
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
                            <input type="email" id="Courriel" name="Courriel" value='{{old('Courriel')}}' placeholder="Courriel associé au compte">
                        </span>
                    </div>
                    <div class="row submit-row">
                        <button type="submit" class="btn btn-block submit-form" onclick="EnvoyerCourrielOublieMotDePasse()">Envoyer un courriel</button>
                    <text>
                        Après avoir appuyé sur le bouton permettant d'envoyer le jeton de réinitialisation à votre adresse couriel, vous devriez recevoir
                        celui-ci sous peu. Si ce n'est pas le cas, veuillez réassayer de nouveau.
                    </text>
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
<script src="js/Visiteur/VoirOublieMotDePasse.js"></script>

@endsection

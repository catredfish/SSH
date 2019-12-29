@extends ('Shared/Master_Layout')
@section ('styles')

<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Visiteur/VoirConnexion.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection

@section ('content')
<!-- Contenu -->
<div class="col-md-12">
  <div class="card">
    <form action="/Connexion/Connexion" method="post">
      @csrf
      <div class = "row">
        <div class="btn-group btn-group-toggle login-type" data-toggle="buttons">
          <label onclick="changeLoginType(1)" class="btn btn-secondary <?php if(Session::get('typeConnexion') == "etudiant" || (Session::get('typeConnexion') == null)){echo "active";}?>">
            <input type="radio" name="options"  id="option1" autocomplete="off" checked>Étudiant
          </label>
          <label onclick="changeLoginType(2)" class="btn btn-secondary <?php if(Session::get('typeConnexion') == "employe"){echo "active";}?>">
            <input type="radio" name="options" id="option2" autocomplete="off"> Employé
          </label>
          <label onclick="changeLoginType(3)" class="btn btn-secondary <?php if(Session::get('typeConnexion') == "courriel"){echo "active";}?>">
            <input type="radio" name="options" id="option3" autocomplete="off"> Visiteur
          </label>
        </div>
      </div>
      <div id="login-form" class="form-container" data-form-container>
        <div class="row">
          <div class="form-title">
            <div id="titre">Se connecter</div>
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
            <span class="req-input" >
              <span id="log-span" class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer votre numéro d'étudiant."> </span>
              <input id="log" data-connexionType = "<?php if(Session::get('typeConnexion') == null){echo "etudiant";} else{echo (Session::get('typeConnexion'));}?>" name="log" value='{{ old('log') }}' type="text" data-min-length="1" placeholder="Numéro d'étudiant à 7 chiffres">
            </span>
          </div>
          <div class="row">
            <span class="req-input input-password">
              <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer votre mot de passe"> </span>
              <input id="motdepasse" data-connexionType = "MotDePasse" name="MotDePasse" type="password" data-min-length="1" placeholder="Mot de passe">
            </span>
          </div>
          <div class="row">
            <a href="/Inscription" class="create-account">S'inscrire </a>
          </div>
          <div class="row submit-row">
            <input hidden = "hidden" id="type-connexion" name="typeConnexion" value="<?php if(Session::get('typeConnexion') == null){echo "etudiant";} else{echo (Session::get('typeConnexion'));}?>">
            <button type="submit" class="btn btn-block submit-form">Se connecter</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- Scripts -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="js/Visiteur/VoirConnexion.js"></script>

@endsection

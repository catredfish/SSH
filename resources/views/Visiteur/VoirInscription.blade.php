@extends ('Shared/Master_Layout')

@section ('styles')
<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Visiteur/VoirInscription.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection

@section ('content')
<!-- Contenu -->
<div class = "container contenu">
  <div class = "row">
  <div id="css-only-modals">
	<input id="modal1" onclick="retourAccueil()" class="css-only-modal-check" type="checkbox" checked/>
	<div class="css-only-modal">
		<label id="labelCliquable" for="modal1" class="css-only-modal-close"><i class="fa fa-times fa-2x"></i></label>
		<h2>Choisissez un type de compte</h2>
		<hr />
    <div class=row>
    <div class="btn-group btn-group-toggle login-type" data-toggle="buttons">
      <label onclick="changeLoginType(1)" class="btn btn-secondary">
        <input type="radio" name="options"  id="option1" autocomplete="off" checked>Étudiant
      </label>
      <label onclick="changeLoginType(2)" class="btn btn-secondary">
        <input type="radio" name="options" id="option2" autocomplete="off"> Employé
      </label>
      <label onclick="changeLoginType(3)" class="btn btn-secondary">
        <input type="radio" name="options" id="option3" autocomplete="off"> Visiteur
      </label>
    </div>
  </div>
  <form action="/FormulaireInscription" method="get">
    <input hidden = "hidden" id="type-connexion" name="typeConnexion" value="">
    <button type="submit" disabled class= "btn btn-primary btn-lg bouton-continuer">Continuer</button>
	</div>
  </form>
<div id="screen-shade"></div>
</div>
</div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="js/Visiteur/VoirInscription.js"></script>

@endsection

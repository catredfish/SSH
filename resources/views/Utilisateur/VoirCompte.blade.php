
@extends ('Shared/Master_Layout')

@section ('styles')
<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Visiteur/VoirInscription.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection

@section ('content')
<!-- Contenu -->
<div class="container">
    <div class="row">
    	<div class="col-md-12">
        <div class="card">
          <form>
          <div id="contact-form" class="form-container" data-form-container>
          <div class="row">
            <div class="form-title">
              <div id="titre">Informations du compte</div>
            </div>
          </div>
          <div class="input-container">
            <div class="row">
              <span class="req-input" >
                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer votre nom complet."> </span>
                <input type="text" data-min-length="8" placeholder="Nom complet">
              </span>
            </div>
            <div class="row">
              <span class="req-input">
                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer votre courriel."> </span>
                <input type="email" placeholder="Courriel">
              </span>
            </div>
            <div class="row">
              <span class="req-input">
                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer votre numéro d'identification."> </span>
                <input type="tel" placeholder="Numéro d'identification">
              </span>
            </div>
            <div class="row">
              <span class="req-input input-password">
                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Votre mot de passe doit contenir un minimum de 8 caractères."> </span>
                <input type="password" data-min-length="8" placeholder="Mot de passe">
              </span>
            </div>
            <div class="row" id="confirmationMDP">
              <span class="req-input confirm-password">
                <span class="input-status" data-toggle="tooltip" data-placement="top" title="Votre confirmation de mot de passe doit être identique au mot de passe."> </span>
                <input type="password" data-min-length="8" placeholder="Confirmation du mot de passe">
              </span>
            </div>
            <div class="row submit-row">
              <button type="button" class="btn btn-block submit-form">Sauvegarder</button>
            </div>
          </div>
          </div>
          </form>
        </div>
		</div>
	</div>
</div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="js/Visiteur/VoirInscription.js"></script>

@endsection

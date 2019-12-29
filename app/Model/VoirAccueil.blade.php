@extends('Shared/Master_Layout')
@section('styles')
<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href='css/Visiteur/VoirConnexion.css'>
<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="css/Visiteur/VoirAccueil.css">
@endsection
@section('content')


<!-- Vidéo -->
<!--<video autoplay muted loop id="myVideo">
  <source src="videos/cegep.mp4" type="video/mp4">
  Votre navigateur ne supporte pas les vidéo MP4.
</video>-->

<img src="images/navigationAccueil.png" id="hautGauche">
<p id="dateEvenement">25 AU 29<br> MARS <?php echo date("Y"); ?></p>

<img src="images/contenuAccueil.png" id="centrer">

<!-- Contenu -->
<div class="content">
    <div class="split left">
        <div class="centered">
            <p>VIENS VIVRE <br/>
                L'EXPÉRIENCE<br/>
                D'UN COLLOQUE <br/>
                SCIENTIFIQUE</p>
        </div>
    </div>

    <div class="split right">
        <div class="centered">
            <p id="gris">INSCRIPTIONS</p>
            <p>25 FÉVRIER <br/>
                AU 15 MARS</p>
        </div>
    </div>
</div>

<img src="images/footerAccueil.PNG" id="basCentre">


<!-- Scripts -->
<script src="js/Visiteur/VoirAccueil.js"></script>

@endsection

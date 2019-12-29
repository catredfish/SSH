@extends ('Shared/Master_Layout')

@section('styles')
<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Administrateur/VoirEnvoyerRappel.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection

@section ('content')
<!-- Contenu -->
<div class="col-md-12">
    <div class="card">
        <form action="/EnvoyerRappel/EnvoyerRappel" method="post">
            <input id='inputAtelier' name='numeroAtelier' value='0' hidden="hidden">
            @csrf
            <div id="contact-form" class="form-container" data-form-container>
                <div class="row">
                    <div class="form-title">
                        <div id="titre">Envoyer un rappel d'inscription</div>
                    </div>
                </div>
                <div class="input-container">
                    <div class="row">
                        <!-- Campus -->
                        <select id="selectAtelier">
                            <option value="" selected disabled hidden>Veuillez choisir un atelier.</option>
                            @foreach($model->getListeAteliers() as $atelier)
                            <option value="{{$atelier->id}}">{{$atelier->Nom}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row submit-row">
                        <button type="button" onclick='EnvoyerRappel()' class="btn btn-block submit-form">Envoyer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="js/Administrateur/VoirEnvoyerRappel.js"></script>
@endsection

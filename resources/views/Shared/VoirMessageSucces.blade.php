@extends ('Shared/Master_Layout')

@section ('styles')
<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Shared/VoirMessageSucces.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection

@section ('content')
<!-- Contenu -->
<div class="col-md-12">
    <div class="card">
        <form>
            <div id="contact-form" class="form-container" data-form-container>
                <div class="row">
                    <div class="form-title">
                        <div id="titre">{{$model->getTitre()}}</div>
                    </div>
                </div>
                <div class="input-container">
                        <div class="row">
                        <h4>{!!$model->getMessage()!!}</h4>
                        </div>
                    <div class="row submit-row">
                        @if ($model->getRetourAccueil())
                        <button type="button" onclick="retourAccueil()" class="btn btn-block submit-form">Retourner à la page d'accueil</button>
                        @else
                        <button type="button" onclick="retour()" class="btn btn-block submit-form">Retourner à la page prédécente</button>
                        @endif
                    </div>
            </div>
        </form>
    </div>
</div>


<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="js/Shared/VoirMessageErreur.js"></script>

@endsection